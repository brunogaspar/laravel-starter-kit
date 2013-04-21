<?php

use Carbon\Carbon;
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
	 * @param  string  $dateFormat
	 * @return string
	 */
	public function created_at($dateFormat = null)
	{
		$date = new Carbon($this->created_at);

		if (is_null($dateFormat))
		{
			return $date->diffForHumans();
		}

		return $date->format($dateFormat);
	}

	/**
	 * Returns the date when the user was last updated.
	 *
	 * @param  string  $dateFormat
	 * @return string
	 */
	public function updated_at($dateFormat = null)
	{
		$date = new Carbon($this->updated_at);

		if (is_null($dateFormat))
		{
			return $date->diffForHumans();
		}

		return $date->format($dateFormat);
	}

}
