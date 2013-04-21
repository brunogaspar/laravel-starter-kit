<?php

use Carbon\Carbon;

class Comment extends Eloquent {

	/**
	 * Get the date the post was created.
	 *
	 * @param  string  $dateFormat
	 * @return string
	 */
	public function created_at($dateFormat = null)
	{
		$date = new Carbon($this->created_at);

		if (is_null($dateFormat))
		{
			return $date->diffForHumans();
		}

		return $date->format($dateFormat);
	}

	/**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->content);
	}

	/**
	 * Get the comment's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Get the comment's post's.
	 *
	 * @return Blog\Post
	 */
	public function post()
	{
		return $this->belongsTo('Post');
	}

}
