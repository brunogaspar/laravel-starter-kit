<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

	/**
	 * Returns the user full name, it simply concatenates
	 * the user first and last name.
	 *
	 * @return string
	 */
	public function fullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	/**
	 * Returns the user gravatar image url.
	 *
	 * @return string
	 */
	public function gravatar()
	{
		return '//gravatar.org/avatar/' . md5(strtolower(trim($this->gravatar)));
	}

	/**
	 * Returns the user creation date.
	 *
	 * @return string
	 */
	public function created_at()
	{
		return ExpressiveDate::make($this->created_at)->getRelativeDate();
	}

	/**
	 * Returns the date when the user was last updated.
	 *
	 * @return string
	 */
	public function updated_at()
	{
		return ExpressiveDate::make($this->updated_at)->getRelativeDate();
	}

}
