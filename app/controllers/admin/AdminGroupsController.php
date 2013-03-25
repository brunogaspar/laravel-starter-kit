<?php

class AdminGroupsController extends AdminController {

	/**
	 * Holds some static permissions
	 *
	 * @var array
	 */
	protected $permissions = array(
		'superuser' => 'Super user',
		'admin'     => 'Admin Access'
	);

	/**
	 * Show a list of all the groups.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the groups
		$groups = Group::paginate(10);

		// Show the page
		return View::make('backend/groups/index', compact('groups'));
	}

	/**
	 * Group create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Get all the available permissions
		$permissions = $this->permissions;

		// Selected permissions
		$selectedPermissions = Input::old('permissions', array());

		// Show the page
		return View::make('backend/groups/create', compact('permissions', 'selectedPermissions'));
	}

	/**
	 * Group create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			try
			{
				// Get the inputs, with some exceptions
				$inputs = Input::except('csrf_token');

				// Was the group created?
				if ($group = Sentry::getGroupProvider()->create($inputs))
				{
					// Redirect to the new group page
					return Redirect::to('backend/groups/' . $group->id . '/edit')->with('success', Lang::get('backend/groups/messages.create.success'));
				}

				// Redirect to the new group page
				return Redirect::to('backend/groups/create')->with('error', Lang::get('backend/groups/messages.create.error'));
			}
			catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
				$error = 'name_required';
			}
			catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
			{
				$error = 'already_exists';
			}

			// Redirect to the group create page
			return Redirect::to('backend/groups/create')->withInput()->with('error', Lang::get('backend/groups/messages.' . $error));
		}

		// Form validation failed
		return Redirect::to('backend/groups/create')->withInput()->withErrors($validator);
	}

	/**
	 * Group update.
	 *
	 * @param  int  $groupId
	 * @return View
	 */
	public function getEdit($groupId = null)
	{
		try
		{
			// Get the group information
			$group = Sentry::getGroupProvider()->findById($groupId);

			// Get all the available permissions
			$permissions = $this->permissions;

			// Get this group permissions
			$groupPermissions = $group->getPermissions();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Redirect::to('backend/groups')->with('error', Lang::get('backend/groups/messages.does_not_exist'));
		}

		// Show the page
		return View::make('backend/groups/edit', compact('group', 'permissions', 'groupPermissions'));
	}

	/**
	 * Group update form processing page.
	 *
	 * @param  int  $groupId
	 * @return Redirect
	 */
	public function postEdit($groupId = null)
	{
		try
		{
			// Get the group information
			$group = Sentry::getGroupProvider()->findById($groupId);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Rediret::to('backend/groups')->with('error', Lang::get('backend/groups/messages.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name' => 'required'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			try
			{
				// Update the group data
				$group->name        = Input::get('name');
				$group->permissions = Input::get('permissions');

				// Was the group updated?
				if ($group->save())
				{
					// Redirect to the group page
					return Redirect::to('backend/groups/' . $groupId . '/edit')->with('success', Lang::get('backend/groups/messages.update.success'));
				}
				else
				{
					// Redirect to the group page
					return Redirect::to('backend/groups/' . $groupId . '/edit')->with('error', Lang::get('backend/groups/messages.update.error'));
				}
			}
			catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
				$error = Lang::get('backend/group/messages.name_required');
			}

			// Redirect to the group page
			return Redirect::to('backend/groups/' . $groupId . '/edit')->withInput()->with('error', $error);
		}

		// Form validation failed
		return Redirect::to('backend/groups/' . $groupId . '/edit')->withInput()->withErrors($validator);
	}

	/**
	 * Delete the given group.
	 *
	 * @param  int  $groupId
	 * @return Redirect
	 */
	public function getDelete($groupId = null)
	{
		try
		{
			// Get group information
			$group = Sentry::getGroupProvider()->findById($groupId);

			// Was the group deleted?
			if($group->delete())
			{
				// Redirect to the group management page
				return Redirect::to('backend/groups')->with('success', Lang::get('backend/group/messages.delete.success'));
			}

			// There was a problem deleting the group
			return Redirect::to('backend/groups')->with('error', Lang::get('backend/groups/messages.delete.error'));
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Redirect to the group management page
			return Redirect::to('backend/groups')->with('error', Lang::get('backend/groups/messages.not_found'));
		}
	}

}
