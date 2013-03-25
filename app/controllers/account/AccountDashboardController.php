<?php

class AccountDashboardController extends AuthorizedController {

	/**
	 * Redirect to the profile page.
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		// Redirect to the profile page
		return Redirect::route('profile');
	}

}
