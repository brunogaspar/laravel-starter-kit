<?php

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel {

	/**
	 * The date fields for the model.
	 *
	 * @var array
	 */
	protected $dates = array(
		'created_at',
		'updated_at',
	);

}
