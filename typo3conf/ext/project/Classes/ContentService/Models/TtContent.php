<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\Helper\CropImage;
use TYPO3\CMS\Core\Resource\ProcessedFile;

/**
 * Project specific tt_content model to append new properties.
 *
 * @property int tx_project_content_carousel_slides
 * @property int tx_project_content_wheel_slides
 * @property int tx_project_image_square
 * @property int tx_wow_raids
 * @property int tx_wow_guild_uid
 */
class TtContent extends \Typo3ContentService\Models\TtContent
{

	/**
	 * Returns all content carousel slides.
	 *
	 * @return array|TxProjectContentCarouselSlide[]
	 */
	public function getContentCarouselSlides(): array
	{
		$where = [
			'parent_id' => $this->getKey(),
			'parent_table' => $this->getTableName(),
		];

		return TxProjectContentCarouselSlide::findAllBy($where);
	}

	/**
	 * Returns all content wheel slides.
	 *
	 * @return array|TxProjectContentWheelSlide[]
	 */
	public function getContentWheelSlides(): array
	{
		$where = [
			'parent_id' => $this->getKey(),
			'parent_table' => $this->getTableName(),
		];

		return TxProjectContentWheelSlide::findAllBy($where);
	}

	/**
	 * @return \TYPO3\CMS\Core\Resource\ProcessedFile
	 */
	public function getImageSquare(): ProcessedFile
	{
		$image = $this->resolveFile('tx_project_image_square');

		return CropImage::getProcessedFile($image, 'square');
	}

	/**
	 * Returns all raids defined by the progression plugin.
	 *
	 * @return array|TxWowRaid[]
	 */
	public function getRaids(): array
	{
		$raidUids = \explode(',', $this->tx_wow_raids);
		$raids = [];

		foreach ($raidUids as $raidUid) {
			$raids[] = TxWowRaid::find((int)$raidUid);
		}

		return $raids;
	}

	/**
	 * @return \Project\Classes\ContentService\Models\TxWowGuild
	 */
	public function getGuild(): TxWowGuild
	{
		return TxWowGuild::find((int) $this->tx_wow_guild_uid);
	}
}
