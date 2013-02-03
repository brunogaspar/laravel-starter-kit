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
	 * Delete the given blog post.
	 *
	 * @param  int  $postId
	 * @return Redirect
	 * @todo   Be able to delete the post comments
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
			// Redirect to the user management page
			return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.delete.success'));
		}

		// There was a problem deleting the blog post
		return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.delete.error'));
	}

}
