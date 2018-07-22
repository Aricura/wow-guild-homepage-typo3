<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_classes table.
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
 * @property int mask
 * @property string name
 * @property string power_type
 */
class TxWowClass extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'tx_wow_classes';

	/**
	 * Fetches a single class model by its unique foreign id.
	 *
	 * @param int $foreignId
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowClass
	 */
	public static function findByForeignId(int $foreignId): self
	{
		$self = new self();

		return $self->loadBy('foreign_id', $foreignId);
	}

	/**
	 * Fetches a single class model by its unique mask index.
	 *
	 * @param int $mask
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowClass
	 */
	public static function findByMask(int $mask): self
	{
		$self = new self();

		return $self->loadBy('mask', $mask);
	}

	/**
	 * Seeds the World of Warcraft class database table.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$response = $battleNet->get('data/character/classes');

		if (!$response->success()) {
			return;
		}

		$classes = $response->getResponseByKey('classes');

		foreach($classes as $class) {
			$model = self::findByForeignId((int) $class['id']);
			$model->pid = 1;
			$model->cruser_id = 1;
			$model->mask = (int) $class['mask'];
			$model->name = $class['name'];
			$model->power_type = \strtolower($class['powerType']);
			$model->store();
		}
	}
}
