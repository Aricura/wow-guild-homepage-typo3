<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\AbstractModel;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_realms table.
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
 * @property int    tx_wow_battle_group_uid
 * @property string slug
 * @property string name
 * @property string type
 * @property string population
 * @property string locale
 */
class TxWowRealm extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_realms';

	/**
	 * Fetches a single realm model by its unique slug.
	 *
	 * @param string $slug
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowRealm
	 */
	public static function findBySlug(string $slug): self
	{
		return self::findBy('slug', \mb_strtolower(\trim($slug)));
	}

	/**
	 * Fetches a single realm model by its unique name.
	 *
	 * @param string $name
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowRealm
	 */
	public static function findByName(string $name): self
	{
		return self::findBy('name', \trim($name));
	}

	/**
	 * Seeds the World of Warcraft realm database table.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$response = $battleNet->get('realm/status');

		if (!$response->success()) {
			return;
		}

		$realms = $response->getResponseByKey('realms');
		$pid = (int)Config::get('tx_wow_realm_folder_uid');

		foreach ($realms as $realm) {
			$battleGroup = TxWowBattleGroup::findBySlug($realm['battlegroup']);
			if (!$battleGroup->exists()) {
				$battleGroup = TxWowBattleGroup::findByName($realm['battlegroup']);
			}

			$model = self::findBySlug($realm['slug']);
			$model->pid = $pid;
			$model->cruser_id = 1;
			$model->tx_wow_battle_group_uid = $battleGroup->getKey();
			$model->slug = \mb_strtolower(\trim($realm['slug']));
			$model->name = \trim($realm['name']);
			$model->type = \mb_strtolower(\trim($realm['type']));
			$model->population = \mb_strtolower(\trim($realm['population']));
			$model->locale = \trim($realm['locale']);
			$model->store();
		}
	}
}
