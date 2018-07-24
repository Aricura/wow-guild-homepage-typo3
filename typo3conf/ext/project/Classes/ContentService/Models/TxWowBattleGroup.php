<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\AbstractModel;
use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_battle_groups table.
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
class TxWowBattleGroup extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_battle_groups';

	/**
	 * Fetches a single battle group model by its unique slug.
	 *
	 * @param string $slug
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowBattleGroup
	 */
	public static function findBySlug(string $slug): self
	{
		return self::findBy('slug', \mb_strtolower(\trim($slug)));
	}

	/**
	 * Fetches a single battle group model by its unique name.
	 *
	 * @param string $name
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowBattleGroup
	 */
	public static function findByName(string $name): self
	{
		return self::findBy('name', \trim($name));
	}

	/**
	 * Seeds the World of Warcraft battle group database table.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$response = $battleNet->get('data/battlegroups/');

		if (!$response->success()) {
			return;
		}

		$battleGroups = $response->getResponseByKey('battlegroups');
		$pid = (int)Config::get('tx_wow_battle_group_folder_uid');

		foreach ($battleGroups as $battleGroup) {
			$model = self::findBySlug($battleGroup['slug']);
			$model->pid = $pid;
			$model->cruser_id = 1;
			$model->slug = \mb_strtolower(\trim($battleGroup['slug']));
			$model->name = \trim($battleGroup['name']);
			$model->store();
		}
	}
}
