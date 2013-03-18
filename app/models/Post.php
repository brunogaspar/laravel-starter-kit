<?php

class Post extends Eloquent {

	/**
	 * Deletes a blog post and all the associated comments.
	 *
	 * @return bool
	 */
	public function delete()
	{
		// Delete the comments
		$this->comments()->delete();

		// Delete the blog post
		return parent::delete();
	}

	/**
	 * Returns a formatted post content entry, this ensures that
	 * line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->content);
	}

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * Get the post's comments.
	 *
	 * @return array
	 */
	public function comments()
	{
		return $this->hasMany('Comment');
	}

	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	public function url()
	{
		return URL::route('view-post', $this->slug);
	}

	/**
	 * Returns the blog post creation date.
	 *
	 * @param  string  $dateFormat
	 * @return string
	 */
	public function created_at($dateFormat = null)
	{
		$date = ExpressiveDate::make($this->created_at);

		if (is_null($dateFormat))
		{
			return $date->getRelativeDate();
		}

		return $date->format($dateFormat);
	}

	/**
	 * Returns the blog post last update date.
	 *
	 * @param  string  $dateFormat
	 * @return string
	 */
	public function updated_at($dateFormat = null)
	{
		$date = ExpressiveDate::make($this->updated_at);

		if (is_null($dateFormat))
		{
			return $date->getRelativeDate();
		}

		return $date->format($dateFormat);
	}

}
