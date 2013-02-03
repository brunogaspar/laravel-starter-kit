<?php

class AccountDashboardController extends AuthorizedController {

	/**
	 * Shows the account main page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Show the page
		return View::make('site/account/dashboard');
	}

}
