<?php

class AdminController extends AuthorizedController {

	/**
	 * Initializer.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// Apply the admin auth filter
		$this->beforeFilter('admin-auth');
	}

}
