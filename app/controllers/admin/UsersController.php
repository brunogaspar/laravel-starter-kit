<?php namespace Controllers\Admin;

use AdminController;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Config;
use Input;
use Lang;
use Redirect;
use Sentry;
use User;
use Validator;
use View;

class UsersController extends AdminController {

	/**
	 * Show a list of all the users.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the users
		$users = new User;

		// Do we want to include the deleted users?
		if (Input::get('withTrashed'))
		{
			$users = $users->withTrashed();
		}

		// Paginate the users
		$users = $users->paginate(10);

		// Show the page
		return View::make('backend/users/index', compact('users'));
	}

	/**
	 * User create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Get all the available groups
		$groups = Sentry::getGroupProvider()->findAll();

		// Get all the available permissions
		$permissions = Config::get('permissions');
		$this->encodeAllPermissions($permissions);

		// Selected groups
		$selectedGroups = Input::old('groups', array());

		// Selected permissions
		$selectedPermissions = Input::old('permissions', array());

		// Show the page
		return View::make('backend/users/create', compact('groups', 'permissions', 'selectedGroups', 'selectedPermissions'));
	}

	/**
	 * User create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'first_name'       => 'required|min:3',
			'last_name'        => 'required|min:3',
			'email'            => 'required|email|unique:users,email',
			'password'         => 'required|between:3,32',
			'password_confirm' => 'required|between:3,32|same:password',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Get the inputs, with some exceptions
			$inputs = Input::except('csrf_token', 'password_confirm', 'groups');

			// Was the user created?
			if ($user = Sentry::getUserProvider()->create($inputs))
			{
				// Assign the selected groups to this user
				foreach (Input::get('groups', array()) as $groupId)
				{
					$group = Sentry::getGroupProvider()->findById($groupId);

					$user->addGroup($group);
				}

				// Prepare the success message
				$success = Lang::get('admin/users/message.success.create');

				// Redirect to the new user page
				return Redirect::to("admin/users/{$user->id}/edit")->with('success', $success);
			}

			// Prepare the error message
			$error = Lang::get('admin/users/message.error.create');

			// Redirect to the user creation page
			return Redirect::route('create/user')->with('error', $error);
		}
		catch (LoginRequiredException $e)
		{
			$error = Lang::get('admin/users/message.user_login_required');
		}
		catch (PasswordRequiredException $e)
		{
			$error = Lang::get('admin/users/message.user_password_required');
		}
		catch (UserExistsException $e)
		{
			$error = Lang::get('admin/users/message.user_exists');
		}

		// Redirect to the user creation page
		return Redirect::route('create/user')->withInput()->with('error', $error);
	}

	/**
	 * User update.
	 *
	 * @param  int
	 * @return View
	 */
	public function getEdit($userId = null)
	{
		try
		{
			// Get the user information
			$user = Sentry::getUserProvider()->findById($userId);

			// Get this user groups
			$userGroups = $user->groups()->lists('name', 'group_id');

			// Get this user permissions
			$userPermissions = array_merge(Input::old('permissions', array('superuser' => -1)), $user->getPermissions());
			$this->encodePermissions($userPermissions);

			// Get a list of all the available groups
			$groups = Sentry::getGroupProvider()->findAll();

			// Get all the available permissions
			$permissions = Config::get('permissions');
			$this->encodeAllPermissions($permissions);
		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_does_not_exist', array('id' => $userId));

			// Redirect to the user management page
			return Redirect::to('admin/users')->with('error', $error);
		}

		// Show the page
		return View::make('backend/users/edit', compact('user', 'groups', 'userGroups', 'permissions', 'userPermissions'));
	}

	/**
	 * User update form processing page.
	 *
	 * @param  int
	 * @return Redirect
	 */
	public function postEdit($userId = null)
	{
		try
		{
			// Get the user information
			$user = Sentry::getUserProvider()->findById($userId);
		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_does_not_exist', array('id' => $userId));

			// Redirect to the user management page
			return Redirect::to('admin/users')->with('error', $error);
		}

		// Declare the rules for the form validation
		$rules = array(
			'first_name' => 'required|min:3',
			'last_name'  => 'required|min:3',
			'email'      => "required|email|unique:users,email,{$user->email},email",
		);

		// Do we want to update the user password?
		if (Input::get('password'))
		{
			$rules['password']         = 'required|between:3,32';
			$rules['password_confirm'] = 'required|between:3,32|same:password';
		}

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Update the user
			$user->first_name  = Input::get('first_name');
			$user->last_name   = Input::get('last_name');
			$user->email       = Input::get('email');
			$user->activated   = Input::get('activated', $user->activated);
			$user->permissions = Input::get('permissions');

			// Do we want to update the user password?
			if ($password = Input::get('password'))
			{
				$user->password = $password;
			}

			// Get the current user groups
			$userGroups = $user->groups()->lists('group_id', 'group_id');

			// Get the selected groups
			$selectedGroups = Input::get('groups', array());

			// Groups comparison between the groups the user currently
			// have and the groups the user wish to have.
			$groupsToAdd    = array_diff($selectedGroups, $userGroups);
			$groupsToRemove = array_diff($userGroups, $selectedGroups);

			// Assign the user to groups
			foreach ($groupsToAdd as $groupId)
			{
				$group = Sentry::getGroupProvider()->findById($groupId);

				$user->addGroup($group);
			}

			// Remove the user from groups
			foreach ($groupsToRemove as $groupId)
			{
				$group = Sentry::getGroupProvider()->findById($groupId);

				$user->removeGroup($group);
			}

			// Was the user updated?
			if ($user->save())
			{
				// Prepare the success message
				$success = Lang::get('admin/users/message.success.update');

				// Redirect to the user page
				return Redirect::to("admin/users/$userId/edit")->with('success', $success);
			}

			// Prepare the error message
			$error = Lang::get('admin/users/message.error.update');
		}
		catch (LoginRequiredException $e)
		{
			$error = Lang::get('admin/users/message.user_login_required');
		}

		// Redirect to the user page
		return Redirect::to("admin/users/$userId/edit")->withInput()->with('error', $error);
	}

	/**
	 * Delete the given user, beware that the logged in user
	 * can't be deleted, makes sense, right?
	 *
	 * @param  int  $userId
	 * @return Redirect
	 */
	public function getDelete($userId = null)
	{
		try
		{
			// Get user information
			$user = Sentry::getUserProvider()->findById($userId);

			// Check if we are not trying to delete ourselves
			if ($user->id === Sentry::getId())
			{
				// Prepare the error message
				$error = Lang::get('admin/users/message.error.delete');

				// Redirect to the user management page
				return Redirect::to('admin/users')->with('error', $error);
			}

			// Do we have permission to delete this user?
			if ($user->isSuperUser() and ! Sentry::getUser()->isSuperUser())
			{
				// Redirect to the user management page
				return Redirect::to('admin/users')->with('error', 'Insufficient permissions!');
			}

			// Delete the user
			$user->delete();

			// Prepare the success message
			$success = Lang::get('admin/users/message.success.delete');

			// Redirect to the user management page
			return Redirect::to('admin/users')->with('success', $success);
		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_does_not_exist', array('id' => $userId));

			// Redirect to the user management page
			return Redirect::to('admin/users')->with('error', $error);
		}
	}


	public function getRestore($userId = null)
	{
		$user = \User::trashed()->find($userId);

		if ( ! is_null($user))
		{
			if ( ! is_null($user->deleted_at))
			{
				$user->restore();

				return Redirect::to('admin/users')->with('success', 'User restored');
			}
		}

		// Prepare the error message
		$error = Lang::get('admin/users/message.user_does_not_exist', array('id' => $userId));

		// Redirect to the user management page
		return Redirect::to('admin/users')->with('error', $error);
	}

}
