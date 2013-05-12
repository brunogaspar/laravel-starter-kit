<?php namespace Controllers\Admin;

use AdminController;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Group;
use Input;
use Lang;
use Redirect;
use Sentry;
use Validator;
use View;

class GroupsController extends AdminController {

	/**
	 * Holds some static permissions
	 *
	 * @var array
	 */
	protected $permissions = array(
		'superuser' => 'Super user',
		'admin'     => 'Admin Access',
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
			'name' => 'required',
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
			$inputs = Input::except('_token');

			// Was the group created?
			if ($group = Sentry::getGroupProvider()->create($inputs))
			{
				// Redirect to the new group page
				return Redirect::to("admin/groups/{$group->id}/edit")->with('success', Lang::get('admin/groups/message.create.success'));
			}

			// Redirect to the new group page
			return Redirect::to('admin/groups/create')->with('error', Lang::get('admin/groups/message.create.error'));
		}
		catch (NameRequiredException $e)
		{
			$error = 'name_required';
		}
		catch (GroupExistsException $e)
		{
			$error = 'already_exists';
		}

		// Redirect to the group create page
		return Redirect::to('admin/groups/create')->withInput()->with('error', Lang::get('admin/groups/message.'.$error));
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
		catch (GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Redirect::to('admin/groups')->with('error', Lang::get('admin/groups/message.does_not_exist'));
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
		catch (GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Rediret::to('admin/groups')->with('error', Lang::get('admin/groups/message.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name' => 'required',
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
			// Update the group data
			$group->name        = Input::get('name');
			$group->permissions = Input::get('permissions');

			// Was the group updated?
			if ($group->save())
			{
				// Redirect to the group page
				return Redirect::to("admin/groups/$groupId/edit")->with('success', Lang::get('admin/groups/message.update.success'));
			}
			else
			{
				// Redirect to the group page
				return Redirect::to("admin/groups/$groupId/edit")->with('error', Lang::get('admin/groups/message.update.error'));
			}
		}
		catch (NameRequiredException $e)
		{
			$error = Lang::get('admin/group/message.name_required');
		}

		// Redirect to the group page
		return Redirect::to("admin/groups/{$groupId}/edit")->withInput()->with('error', $error);
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

			// Delete the group
			$group->delete();

			// Redirect to the group management page
			return Redirect::to('admin/groups')->with('success', Lang::get('admin/groups/message.delete.success'));
		}
		catch (GroupNotFoundException $e)
		{
			// Redirect to the group management page
			return Redirect::to('admin/groups')->with('error', Lang::get('admin/groups/message.not_found'));
		}
	}

}
