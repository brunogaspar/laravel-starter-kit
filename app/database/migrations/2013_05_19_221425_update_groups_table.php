<?php

use Illuminate\Database\Migrations\Migration;

class UpdateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Update the groups table
		Schema::table('groups', function($table)
		{
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Update the groups table
		Schema::table('groups', function($table)
		{
			$table->dropColumns('deleted_at');
		});
	}

}
