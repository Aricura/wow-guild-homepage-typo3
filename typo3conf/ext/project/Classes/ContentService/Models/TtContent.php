<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

/**
 * Project specific tt_content model to append new properties.
 *
 * @property int tx_project_content_carousel_slides
 */
class TtContent extends \Typo3ContentService\Models\TtContent
{

	/**
	 * Returns all content carousel slides.
	 *
	 * @return array|TxProjectContentCarouseSlide[]
	 */
	public function getContentCarouselSlides(): array
	{
		$where = [
			'parent_id' => $this->getKey(),
			'parent_table' => $this->getTableName(),
		];

		return TxProjectContentCarouseSlide::findAllBy($where);
	}
}
