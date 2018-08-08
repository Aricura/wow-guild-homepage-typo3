<?php

declare(strict_types=1);

namespace Project\Classes\Template;

use Project\Classes\Base;
use Project\Classes\ContentService\Models\Page;
use Project\Classes\ContentService\Models\TxWowGuild;

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

		$guild = TxWowGuild::getAll()[0];

		$twigData = [
			'root' => $rootPage,
			'navigation' => $navigation,
			'guild_name' => $guild->name,
			'realm_name' => \ucwords($guild->getRealm()->name),
			'fraction_name' => \ucwords($guild->getFraction()->name),
		];

		return $this->twigArray('page/master.html.twig', $twigData);
	}
}
