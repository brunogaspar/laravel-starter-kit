<?php

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel {

	/**
	 * Returns the group creation date.
	 *
	 * @return string
	 */
	public function created_at()
	{
		return ExpressiveDate::make($this->created_at)->getRelativeDate();
	}

	/**
	 * Returns the group last update date.
	 *
	 * @return string
	 */
	public function updated_at()
	{
		return ExpressiveDate::make($this->updated_at)->getRelativeDate();
	}

}
