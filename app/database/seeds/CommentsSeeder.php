<?php

class CommentsSeeder extends Seeder {

	public function run()
	{
		// Delete all the blog posts comments
		DB::table('comments')->delete();

		// Post 1 comments
		for ($i = 1; $i <= 3; $i++)
		{
			$comment = array(
				'user_id'    => 1,
				'post_id'    => 1,
				'content'    => file_get_contents(__DIR__ . '/comment' . $i . '-content.txt'),
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			);
			Comment::create($comment);
		}

		// Post 2 comments
		for ($i = 1; $i <= 2; $i++)
		{
			$comment = array(
				'user_id'    => 1,
				'post_id'    => 2,
				'content'    => file_get_contents(__DIR__ . '/comment' . $i . '-content.txt'),
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			);
			Comment::create($comment);
		}

		// Post 3 comments
		for ($i = 1; $i <= 1; $i++)
		{
			$comment = array(
				'user_id'    => 1,
				'post_id'    => 3,
				'content'    => file_get_contents(__DIR__ . '/comment' . $i . '-content.txt'),
				'created_at' => new DateTime,
				'updated_at' => new DateTime,
			);
			Comment::create($comment);
		}
	}

}
