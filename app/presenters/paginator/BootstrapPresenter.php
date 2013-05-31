<?php namespace Presenters\Paginator;

use Illuminate\Pagination\BootstrapPresenter as Presenter;

class BootstrapPresenter extends Presenter {

	/**
	 * Create a range of pagination links.
	 *
	 * @param  int  $start
	 * @param  int  $end
	 * @return string
	 */
	public function getPageRange($start, $end)
	{
		$pages = array();

		for ($page = $start; $page <= $end; $page++)
		{
			// If the current page is equal to the page we're iterating on, we will create a
			// disabled link for that page. Otherwise, we can create a typical active one
			// for the link. These views use the "Twitter Bootstrap" styles by default.
			if ($this->currentPage == $page)
			{
				$pages[] = '<li class="active"><span>'.$page.'</span></li>';
			}
			else
			{
				$pages[] = $this->getLink($page);
			}
		}

		return implode('', $pages);
	}

	/**
	 * Get the previous page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getPrevious($text = '&laquo;')
	{
		// If the current page is less than or equal to one, it means we can't go any
		// further back in the pages, so we will render a disabled previous button
		// when that is the case. Otherwise, we will give it an active "status".
		if ($this->currentPage <= 1)
		{
			return '<li class="disabled"><span>'.$text.'</span></li>';
		}
		else
		{
			$url = $this->paginator->getUrl($this->currentPage - 1);

			return '<li><a href="'.$url.'">'.$text.'</a></li>';
		}
	}

	/**
	 * Get the next page pagination element.
	 *
	 * @param  string  $text
	 * @return string
	 */
	public function getNext($text = '&raquo;')
	{
		// If the current page is greater than or equal to the last page, it means we
		// can't go any further into the pages, as we're already on this last page
		// that is available, so we will make it the "next" link style disabled.
		if ($this->currentPage >= $this->lastPage)
		{
			return '<li class="disabled"><span>'.$text.'</span></li>';
		}
		else
		{
			$url = $this->paginator->getUrl($this->currentPage + 1);

			return '<li><a href="'.$url.'">'.$text.'</a></li>';
		}
	}

	/**
	 * Get a pagination "dot" element.
	 *
	 * @return string
	 */
	public function getDots()
	{
		return '<li class="disabled"><span>...</span></li>';
	}

	/**
	 * Create a pagination slider link.
	 *
	 * @param  mixed   $page
	 * @return string
	 */
	public function getLink($page)
	{
		$url = $this->paginator->getUrl($page);

		return '<li><a href="'.$url.'">'.$page.'</a></li>';
	}

}
