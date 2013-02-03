<?php

use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the `Posts` table
		Schema::create('posts', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('title');
			$table->string('slug');
			$table->text('content');
			$table->string('meta_title');
			$table->string('meta_description');
			$table->string('meta_kewords');
			$table->timestamps();

			#$table->foreign('post_id')->references('id')->on('comments')->on_delete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Delete the `Posts` table
		Schema::drop('posts');
	}

}
