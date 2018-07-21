<?php

declare(strict_types=1);

namespace Project\Classes\Template;

use Project\Classes\Base;

/**
 * Renders the master template of the website.
 */
class Master extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		return $this->twig('page/master.html.twig');
	}
}
