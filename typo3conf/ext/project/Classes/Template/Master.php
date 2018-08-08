<?php

declare(strict_types=1);

namespace Project\Classes\Template;

use Project\Classes\Base;
use Project\Classes\ContentService\Models\Page;

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
		$rootPage = Page::find(1);
		$navigation = [];

		foreach($rootPage->getContentElements() as $element) {
			if ('' !== $element->getNavTitle()) {
				$navigation[$element->getKey()] = $element->getNavTitle();
			}
		}

		$twigData = [
			'root' => $rootPage,
			'navigation' => $navigation,
		];

		return $this->twigArray('page/master.html.twig', $twigData);
	}
}
