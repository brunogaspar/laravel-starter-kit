<?php

class AdminBlogsController extends AdminController {

	/**
	 * Show a list of all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the blog posts
		$posts = Post::orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('admin/blogs/index', compact('posts'));
	}

	/**
	 * Blog post create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		return View::make('admin/blogs/create');
	}

	/**
	 * Blog post create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required|min:3',
			'content' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Create a new blog post
			$post = new Post;

			// Update the blog post data
			$post->title            = Input::get('title');
			$post->slug             = convert_to_slug(Input::get('title'));
			$post->content          = Input::get('content');
			$post->meta_title       = Input::get('meta-title');
			$post->meta_description = Input::get('meta-description');
			$post->meta_keywords    = Input::get('meta-keywords');
			$post->user_id          = Sentry::getId();

			// Was the blog post created?
			if($post->save())
			{
				// Redirect to the new blog post page
				return Redirect::to('admin/blogs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
			}

			// Redirect to the blog post create page
			return Redirect::to('admin/blogs/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
		}

		// Form validation failed
		return Redirect::to('admin/blogs/create')->withInput()->withErrors($validator);
	}

	/**
	 * Blog post update.
	 *
	 * @param  int  $postId
	 * @return View
	 */
	public function getEdit($postId = null)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.does_not_exist'));
		}

		// Show the page
		return View::make('admin/blogs/edit', compact('post'));
	}

	/**
	 * Blog Post update form processing page.
	 *
	 * @param  int  $postId
	 * @return Redirect
	 */
	public function postEdit($postId = null)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.does_not_exist'));
		}

		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required|min:3',
			'content' => 'required|min:3'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Update the blog post data
			$post->title            = Input::get('title');
			$post->slug             = convert_to_slug(Input::get('title'));
			$post->content          = Input::get('content');
			$post->meta_title       = Input::get('meta-title');
			$post->meta_description = Input::get('meta-description');
			$post->meta_keywords    = Input::get('meta-keywords');

			// Was the blog post updated?
			if($post->save())
			{
				// Redirect to the new blog post page
				return Redirect::to('admin/blogs/' . $postId . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'));
			}

			// Redirect to the blogs post management page
			return Redirect::to('admin/blogs/' . $postId . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
		}

		// Form validation failed
		return Redirect::to('admin/blogs/' . $postId . '/edit')->withInput()->withErrors($validator);
	}

	/**
	 * Delete the given blog post.
	 *
	 * @param  int  $postId
	 * @return Redirect
	 */
	public function getDelete($postId)
	{
		// Check if the blog post exists
		if (is_null($post = Post::find($postId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.not_found'));
		}

		// Was the blog post deleted?
		if($post->delete())
		{
			// Delete this posts comments
			$post->comments()->delete();

			// Redirect to the blog posts management page
			return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.delete.success'));
		}

		// There was a problem deleting the blog post
		return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

}


function convert_to_slug($str)
{
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '-', $str);
	$str = preg_replace('/-+/', "-", $str);
	return $str;
}
