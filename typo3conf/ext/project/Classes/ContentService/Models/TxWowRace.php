<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_races table.
 *
 * @property int uid
 * @property int pid
 * @property int tstamp
 * @property int crdate
 * @property int cruser_id
 * @property int sorting
 * @property int deleted
 * @property int hidden
 * @property int sys_language_uid
 * @property int foreign_id
 * @property int tx_wow_fraction_uid
 * @property int mask
 * @property string name
 */
class TxWowRace extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'tx_wow_races';

	/**
	 * Fetches a single race model by its unique foreign id.
	 *
	 * @param int $foreignId
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowRace
	 */
	public static function findByForeignId(int $foreignId): self
	{
		$self = new self();

		return $self->loadBy('foreign_id', $foreignId);
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
		$self = new self();

		return $self->loadBy('mask', $mask);
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

		foreach($races as $race) {
			$fraction = TxWowFraction::findBySlug($race['side']);

			$model = self::findByForeignId((int) $race['id']);
			$model->pid = 1;
			$model->cruser_id = 1;
			$model->tx_wow_fraction_uid = $fraction->getKey();
			$model->mask = (int) $race['mask'];
			$model->name = $race['name'];
			$model->store();
		}
	}
}
