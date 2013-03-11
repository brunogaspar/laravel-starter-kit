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
		Schema::create('authentications', function($table)
		{
                    $table->engine = 'InnoDB';
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
		Schema::drop('authentications');
	}

}