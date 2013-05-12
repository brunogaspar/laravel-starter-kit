<?php

class BlogController extends BaseController {


	protected $parents  = array();
	protected $children = array();


	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Get all the blog posts
		$posts = Post::orderBy('created_at', 'DESC')->paginate(10);

		// Show the page
		return View::make('frontend.blog.index', compact('posts'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = Post::with('comments')->where('slug', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that a page or a blog post
			// don't exist. So, this means that it is time for 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'DESC')->get();

		$teste = array();

		foreach ($comments as $comment)
		{
			if (is_null($comment->parent_id))
			{
				$this->parents[$comment->id][] = $comment;
			}
			else
			{
				$this->children[$comment->parent_id][] = $comment;
			}
		}

		// Show the page
		return View::make('frontend.blog.view-post', compact('post', 'comments'));
	}

	protected function format_comment($comment, $depth)
	{
		for ($depth; $depth > 0; $depth --)
		{
			echo "\t";
		}

		echo $comment->content;
		echo "\n";
	}

	protected function print_parent($comment, $depth = 0)
	{
		foreach ($comment as $c)
		{
			$this->format_comment($c, $depth);

			if (isset($this->children[$c->id]))
			{
				$this->print_parent($this->children[$c->id], $depth + 1);
			}
		}
	}

	protected function print_comments()
	{
		foreach ($this->parents as $p)
		{
			$this->print_parent($p);
		}
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{
		// The user needs to be logged in, make that check please
		if ( ! Sentry::check())
		{
			return Redirect::to("blog/$slug#comments")->with('error', 'You need to be logged in to post comments!');
		}

		// Get this blog post data
		$post = Post::where('slug', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3',
		);

		// Create a new validator instance from our dynamic rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now
		if ($validator->fails())
		{
			// Redirect to this blog post page
			return Redirect::to("blog/$slug#comments")->withInput()->withErrors($validator);
		}

		// Save the comment
		$comment = new Comment;
		$comment->user_id = Sentry::getUser()->id;
		$comment->content = Input::get('comment');

		// Was the comment saved with success?
		if($post->comments()->save($comment))
		{
			// Redirect to this blog post page
			return Redirect::to("blog/$slug#comments")->with('success', 'Your comment was successfully added.');
		}

		// Redirect to this blog post page
		return Redirect::to("blog/$slug#comments")->with('error', 'There was a problem adding your comment, please try again.');
	}

}
