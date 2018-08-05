<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;

/**
 * Renders the raid progression plugin.
 */
class RaidProgression extends Base
{

	/**
	 * @return string
	 */
	public function render(): string
	{
		return $this->twig('raid-progression/template.html.twig');
	}
}
