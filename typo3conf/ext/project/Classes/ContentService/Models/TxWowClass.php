<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\AbstractModel;
use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_classes table.
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
 * @property int    foreign_id
 * @property int    mask
 * @property string name
 * @property string power_type
 */
class TxWowClass extends AbstractModel
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
		return self::findBy('foreign_id', $foreignId);
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
		return self::findBy('mask', $mask);
	}

	/**
	 * Fetches a single class model by its unique name.
	 *
	 * @param string $name
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowClass
	 */
	public static function findByName(string $name): self
	{
		return self::findBy('name', \trim($name));
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
		$pid = (int)Config::get('tx_wow_class_folder_uid');

		foreach ($classes as $class) {
			$model = self::findByForeignId((int)$class['id']);
			$model->pid = $pid;
			$model->cruser_id = 1;
			$model->foreign_id = (int)$class['id'];
			$model->mask = (int)$class['mask'];
			$model->name = \trim($class['name']);
			$model->power_type = \mb_strtolower(\trim($class['powerType']));
			$model->store();
		}
	}
}
