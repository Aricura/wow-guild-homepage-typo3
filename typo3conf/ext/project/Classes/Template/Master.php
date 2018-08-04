<?php

declare(strict_types=1);

namespace Project\Classes\Template;

use Project\Classes\Base;
use Typo3ContentService\Models\Page;

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
		$twigData = [
			'root' => Page::find(1),
			'page' => Page::find((int)$this->frontendController()->id),
		];

		return $this->twigArray('page/master.html.twig', $twigData);
	}
}
