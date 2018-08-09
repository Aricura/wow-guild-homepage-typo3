<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;

/**
 * Renders the default text plugin.
 */
class Text extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		return $this->twig('text/template.html.twig');
	}
}
