<?php

declare(strict_types=1);

namespace Project\Classes\Controller;

use Project\Classes\Base;
use Project\Classes\ContentService\Api\WowProgress;

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
		$rank = new WowProgress($this->element->getGuild());
		$rank->fetch();

		$this->element->setAttribute('rank', $rank);

		return $this->twig('raid-progression/template.html.twig');
	}
}
