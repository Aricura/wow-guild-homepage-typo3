<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Typo3ContentService\Models\AbstractModel;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_fractions table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property int    sys_language_uid
 * @property string slug
 * @property string name
 */
class TxWowFraction extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_fractions';

	/**
	 * Fetches a single fraction model by its unique slug.
	 *
	 * @param string $slug
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function findBySlug(string $slug): self
	{
		$model = self::findBy('slug', \mb_strtolower(\trim($slug)));

		if (!$model->exists()) {
			$model->slug = \mb_strtolower(\trim($slug));
		}

		return $model;
	}

	/**
	 * Returns the alliance fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getAlliance(): self
	{
		return self::findBySlug('alliance');
	}

	/**
	 * Returns the horde fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getHorde(): self
	{
		return self::findBySlug('horde');
	}

	/**
	 * Returns the neutral fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getNeutral(): self
	{
		return self::findBySlug('neutral');
	}

	/**
	 * Fetches a single fraction model by its unique index.
	 *
	 * @param int $index
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function findByIndex(int $index): self
	{
		switch ($index) {
			case 0:
			default:
				return self::getAlliance();
			case 1:
				return self::getHorde();
			case 2:
				return self::getNeutral();
		}
	}

	/**
	 * Seeds the World of Warcraft fraction database table.
	 */
	public static function seed()
	{
		$pid = (int)Config::get('tx_wow_fraction_folder_uid');

		$alliance = self::getAlliance();
		$alliance->pid = $pid;
		$alliance->cruser_id = 1;
		$alliance->name = \ucfirst($alliance->slug);
		$alliance->store();

		$horde = self::getHorde();
		$horde->pid = $pid;
		$horde->cruser_id = 1;
		$horde->name = \ucfirst($horde->slug);
		$horde->store();

		$neutral = self::getNeutral();
		$neutral->pid = $pid;
		$neutral->cruser_id = 1;
		$neutral->name = \ucfirst($neutral->slug);
		$neutral->store();
	}
}
