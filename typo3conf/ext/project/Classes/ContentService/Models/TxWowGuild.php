<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_guilds table.
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
 * @property int    tx_wow_realm_uid
 * @property int    tx_wow_fraction_uid
 * @property string name
 * @property int    level
 * @property int    achievement_points
 * @property string last_modified
 */
class TxWowGuild extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_guilds';

	/**
	 * Seed all information about all guilds.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$guilds = self::all();

		/** @var self $guild */
		foreach ($guilds as $guild) {
			$realm = (new TxWowRealm())->load($guild->tx_wow_realm_uid);
			$response = $battleNet->get(\sprintf('guild/%s/%s', $realm->name, $guild->name));

			if (!$response->success()) {
				continue;
			}

			$fraction = TxWowFraction::findByIndex((int)$response->getResponseByKey('side'));
			$lastModified = (int)$response->getResponseByKey('lastModified') / 1000;

			$guild->tx_wow_fraction_uid = $fraction->getKey();
			$guild->name = $response->getResponseByKey('name');
			$guild->level = (int)$response->getResponseByKey('level');
			$guild->achievement_points = (int)$response->getResponseByKey('achievementPoints');
			$guild->last_modified = \date('Y-m-d H:i:s', $lastModified);
			$guild->store();
		}
	}
}
