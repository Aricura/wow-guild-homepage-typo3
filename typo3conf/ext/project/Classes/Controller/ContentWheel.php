<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;

/**
 * Renders the content wheel plugin.
 */
class ContentWheel extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		return $this->twig('content-wheel/template.html.twig');
	}
}
