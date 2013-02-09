<?php

class PostsSeeder extends Seeder {

	public function run()
	{
		// Common
		$common = array(
			'user_id' => 1,
			'content' => file_get_contents(__DIR__ . '/post-content.txt')
		);

		// Blog post 1
		$post1 = array_merge($common, array(
			'title'      => 'Lorem ipsum dolor sit amet',
			'slug'       => 'lorem-ipsum-dolor-sit-amet',
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		// Blog post 2
		$post2 = array_merge($common, array(
			'title'      => 'Vivendo suscipiantur vim te vix',
			'slug'       => 'vivendo-suscipiantur-vim-te-vix',
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		// Blog post 3
		$post3 = array_merge($common, array(
			'title'      => 'In iisque similique reprimique eum',
			'slug'       => 'in-iisque-similique-reprimique-eum',
			'created_at' => new DateTime,
			'updated_at' => new DateTime
		));

		// Delete all the blog posts
		DB::table('posts')->delete();

		// Create the blog posts
		Post::create($post1);
		Post::create($post2);
		Post::create($post3);
	}

}
