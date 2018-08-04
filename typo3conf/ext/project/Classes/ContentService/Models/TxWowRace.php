<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Typo3ContentService\Models\AbstractModel;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_races table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property int    foreign_id
 * @property int    tx_wow_fraction_uid
 * @property int    mask
 * @property string name
 */
class TxWowRace extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_races';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';

	/**
	 * Fetches a single race model by its unique foreign id.
	 *
	 * @param int $foreignId
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowRace
	 */
	public static function findByForeignId(int $foreignId): self
	{
		return self::findBy('foreign_id', $foreignId);
	}

	/**
	 * Fetches a single race model by its unique mask index.
	 *
	 * @param int $mask
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowRace
	 */
	public static function findByMask(int $mask): self
	{
		return self::findBy('mask', $mask);
	}

	/**
	 * Seeds the World of Warcraft race database table.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$response = $battleNet->get('data/character/races');

		if (!$response->success()) {
			return;
		}

		$races = $response->getResponseByKey('races');
		$pid = (int)Config::get('tx_wow_race_folder_uid');

		foreach ($races as $race) {
			$fraction = TxWowFraction::findBySlug($race['side']);

			$model = self::findByForeignId((int)$race['id']);
			$model->pid = $pid;
			$model->cruser_id = 1;
			$model->foreign_id = (int)$race['id'];
			$model->tx_wow_fraction_uid = $fraction->getKey();
			$model->mask = (int)$race['mask'];
			$model->name = \trim($race['name']);
			$model->store();
		}
	}
}
