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
		return View::make('admin/groups/index', compact('groups'));
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
		return View::make('admin/groups/create', compact('permissions', 'selectedPermissions'));
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
				$inputs = Input::except('csrf_token', 'permissions');
				# added permissions for a quick fix for Sentry permissions bug, for now !

				// Was the group create?
				if ($group = Sentry::getGroupProvider()->create($inputs))
				{
					#### quick fix for Sentry permissions issue !
					if(Input::get('permissions'))
					{
						$permissions = array();
						foreach (Input::get('permissions') as $permissionId => $value)
						{
							$permissions[ $permissionId ] = (int) $value;
						}

						$group->permissions = $permissions;
						$group->save();
					}
					###########################################

					// Redirect to the new group page
					return Redirect::to('admin/groups/' . $group->id . '/edit')->with('success', Lang::get('admin/groups/messages.create.success'));
				}

				// Redirect to the new group page
				return Redirect::to('admin/groups/create')->with('error', Lang::get('admin/groups/messages.create.error'));
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
			return Redirect::to('admin/groups/create')->withInput()->with('error', Lang::get('admin/groups/messages.' . $error));
		}

		// Group validation went wrong
		return Redirect::to('admin/groups/create')->withInput()->withErrors($validator);
	}

	/**
	 * Group update.
	 *
	 * @param  int
	 * @return View
	 */
	public function getEdit($groupId)
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
			return Redirect::to('admin/groups')->with('error', Lang::get('admin/groups/messages.does_not_exist'));
		}

		// Show the page
		return View::make('admin/groups/edit', compact('group', 'permissions', 'groupPermissions'));
	}

	/**
	 * Group update form processing page.
	 *
	 * @param  int
	 * @return Redirect
	 */
	public function postEdit($groupId)
	{
		try
		{
			// Get the group information
			$group = Sentry::getGroupProvider()->findById($groupId);
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Rediret::to('admin/groups')->with('error', Lang::get('admin/groups/messages.does_not_exist'));
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
				// Update the group
				$group->name = Input::get('name');

				// Update group permissions
				$permissions = array();
				foreach (Input::get('permissions') as $permissionId => $value)
				{
					$permissions[ $permissionId ] = (int) $value;
				}
				$group->permissions = $permissions;

				// Was the group updated?
				if ($group->save())
				{
					// Redirect to the group page
					return Redirect::to('admin/groups/' . $groupId . '/edit')->with('success', Lang::get('admin/groups/messages.update.success'));
				}
				else
				{
					// Redirect to the group page
					return Redirect::to('admin/groups/' . $groupId . '/edit')->with('error', Lang::get('admin/groups/messages.update.error'));
				}
			}
			catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
			{
				$error = Lang::get('admin/group/messages.name_required');
			}

			// Redirect to the group page
			return Redirect::to('admin/groups/' . $groupId . '/edit')->withInput()->with('error', $error);
		}

		// Group validation went wrong
		return Redirect::to('admin/groups/' . $groupId . '/edit')->withInput()->withErrors($validator);
	}


	/**
	 * Delete the given group.
	 *
	 * @param  int  $groupId
	 * @return Redirect
	 */
	public function getDelete($groupId)
	{
		try
		{
			// Get group information
			$group = Sentry::getGroupProvider()->findById($groupId);

			// Was the group deleted?
			if($group->delete())
			{
				// Redirect to the group management page
				return Redirect::to('admin/groups')->with('success', Lang::get('admin/group/messages.delete.success'));
			}

			// There was a problem deleting the group
			return Redirect::to('admin/groups')->with('error', Lang::get('admin/groups/messages.delete.error'));
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			// Redirect to the group management page
			return Redirect::to('admin/groups')->with('error', Lang::get('admin/groups/messages.not_found'));
		}
	}

}
