<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

/**
 * Project specific pages model to append new properties.
 */
class Page extends \Typo3ContentService\Models\Page
{
	/**
	 * Returns all content elements which are defined on this page.
	 * Only content elements in their origin language are returned (ignore translations).
	 *
	 * @return array|TtContent[]
	 */
	public function getContentElements(): array
	{
		return $this->getContentElementsByLanguage(0);
	}

	/**
	 * Returns all content elements which are defined on this page.
	 * Only content elements for the specified language / translation are returned.
	 *
	 * @param int $languageIndex
	 *
	 * @return array
	 */
	public function getContentElementsByLanguage(int $languageIndex): array
	{
		$dummy = new TtContent();

		$where = [
			$dummy->getParentColumnName() => ['eq', $this->getKey()],
			$dummy->getLanguageIndexColumnName() => $languageIndex,
		];

		return TtContent::findAllBy($where);
	}
}
