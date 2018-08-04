<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;

/**
 * Renders the master template of the website.
 */
class ContentCarousel extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		return $this->twig('content-carousel/template.html.twig');
	}
}