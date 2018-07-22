<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;
use Project\Classes\Helper\Config;

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

		$guildPid = (int)Config::get('tx_wow_guild_folder_uid');
		$guildMemberPid = (int)Config::get('tx_wow_guild_member_folder_uid');

		/** @var self $guild */
		foreach ($guilds as $guild) {
			$realm = (new TxWowRealm())->load($guild->tx_wow_realm_uid);
			$response = $battleNet->get(\sprintf('guild/%s/%s', $realm->name, $guild->name), ['fields' => 'members']);

			if (!$response->success()) {
				continue;
			}

			$fraction = TxWowFraction::findByIndex((int)$response->getResponseByKey('side'));
			$lastModified = (int)$response->getResponseByKey('lastModified') / 1000;

			$guild->pid = $guildPid;
			$guild->tx_wow_fraction_uid = $fraction->getKey();
			$guild->name = $response->getResponseByKey('name');
			$guild->level = (int)$response->getResponseByKey('level');
			$guild->achievement_points = (int)$response->getResponseByKey('achievementPoints');
			$guild->last_modified = \date('Y-m-d H:i:s', $lastModified);
			$guild->store();

			$members = $response->getResponseByKey('members');

			foreach ($members as $member) {
				$character = (array)$member['character'];

				$realm = TxWowRealm::findBySlug($character['realm']);
				if (!$realm->exists()) {
					$realm = TxWowRealm::findByName($character['realm']);
				}
				$class = TxWowClass::findByForeignId((int)$character['class']);
				$race = TxWowRace::findByForeignId((int)$character['race']);
				$lastModified = (int)$character['lastModified'] / 1000;

				$guildMember = TxWowGuildMember::findByGuildAndName($guild, $character['name']);
				$guildMember->pid = $guildMemberPid;
				$guildMember->cruser_id = 1;
				$guildMember->tx_wow_realm_uid = $realm->getKey();
				$guildMember->tx_wow_race_uid = $race->getKey();
				$guildMember->tx_wow_class_uid = $class->getKey();
				$guildMember->guild_rank = (int)$member['rank'];
				$guildMember->gender = (int)$character['gender'];
				$guildMember->level = (int)$character['level'];
				$guildMember->achievement_points = (int)$character['achievementPoints'];
				$guildMember->thumbnail = $character['thumbnail'];
				$guildMember->last_modified = \date('Y-m-d H:i:s', $lastModified);
				$guildMember->store();
			}
		}
	}
}
