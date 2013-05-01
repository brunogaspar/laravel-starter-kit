<?php

use Carbon\Carbon;
use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel {

	/**
	 * Returns the group creation date.
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
	 * Returns the group last update date.
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
