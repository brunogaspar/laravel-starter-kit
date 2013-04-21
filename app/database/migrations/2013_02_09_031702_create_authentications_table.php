<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Authentications` table
		Schema::create('authentications', function($table)
		{
			$table->increments('id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('provider');
			$table->string('provider_uid');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Delete the `Authentications` table
		Schema::drop('authentications');
	}

}
