<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Update the users table
		Schema::table('users', function($table)
		{
			$table->softDeletes();
			$table->string('website');
			$table->string('country');
			$table->string('gravatar');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Update the users table
		Schema::table('users', function($table)
		{
			$table->dropColumns('website', 'country', 'gravatar');
		});
	}

}
