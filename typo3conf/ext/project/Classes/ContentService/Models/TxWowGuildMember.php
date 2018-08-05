<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Typo3ContentService\Models\AbstractModel;
use Project\Classes\Helper\Config;

/**
 * Base model representing any record of the tx_wow_guild_members table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property int    tx_wow_guild_uid
 * @property int    tx_wow_realm_uid
 * @property int    tx_wow_race_uid
 * @property int    tx_wow_class_uid
 * @property int    tx_wow_class_specialisation_uid
 * @property int    guild_rank
 * @property int    gender
 * @property string name
 * @property int    level
 * @property int    achievement_points
 * @property string thumbnail
 * @property double item_level_equipped
 * @property double item_level_total
 * @property string last_modified
 * @property int    is_raid_member
 */
class TxWowGuildMember extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_guild_members';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';

	/**
	 * @return \Project\Classes\ContentService\Models\TxWowClass
	 */
	public function getClass(): TxWowClass
	{
		return TxWowClass::find($this->tx_wow_class_uid);
	}

	/**
	 * @return \Project\Classes\ContentService\Models\TxWowClassSpecialisation
	 */
	public function getSpecialisation(): TxWowClassSpecialisation
	{
		return TxWowClassSpecialisation::find($this->tx_wow_class_specialisation_uid);
	}

	/**
	 * @return string
	 */
	public function getThumbnailPath(): string
	{
		return \sprintf('https://render-eu.worldofwarcraft.com/character/%s', $this->thumbnail);
	}

	/**
	 * @return string
	 */
	public function getProfilePicturePath(): string
	{
		$url = \str_replace('avatar', 'main', $this->getThumbnailPath());

		return $url.'?alt=/wow/static/images/2d/profilemain/class/6-1.jpg';
	}

	/**
	 * Fetches a single guild member model by its unique parent guild and name combination.
	 *
	 * @param TxWowGuild $guild
	 * @param string     $name
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowGuildMember
	 */
	public static function findByGuildAndName(TxWowGuild $guild, string $name): self
	{
		$where = [
			'tx_wow_guild_uid' => $guild->getKey(),
			'name' => \trim($name),
		];

		$members = self::findAllBy($where, 'AND', 0, 1);

		return \count($members) ? $members[0] : new self;
	}

	/**
	 * Seed all information about all guild members.
	 */
	public static function seed()
	{
		$battleNet = new BattleNet();
		$guildMembers = self::getAll();
		$pid = (int)Config::get('tx_wow_guild_member_folder_uid');

		/** @var self $guildMember */
		foreach ($guildMembers as $guildMember) {
			$realm = TxWowRealm::find($guildMember->tx_wow_realm_uid);
			$response = $battleNet->get(\sprintf('character/%s/%s', $realm->name, $guildMember->name), ['fields' => 'items']);

			if (!$response->success()) {
				continue;
			}

			$realm = TxWowRealm::findBySlug((string)$response->getResponseByKey('realm'));
			if (!$realm->exists()) {
				$realm = TxWowRealm::findByName((string)$response->getResponseByKey('realm'));
			}
			$class = TxWowClass::findByForeignId((int)$response->getResponseByKey('class'));
			$race = TxWowRace::findByForeignId((int)$response->getResponseByKey('race'));
			$lastModified = (int)$response->getResponseByKey('lastModified') / 1000;

			$guildMember->pid = $pid;
			$guildMember->cruser_id = 1;
			$guildMember->name = \trim($response->getResponseByKey('name'));
			$guildMember->tx_wow_realm_uid = $realm->getKey();
			$guildMember->tx_wow_race_uid = $race->getKey();
			$guildMember->tx_wow_class_uid = $class->getKey();
			$guildMember->gender = (int)$response->getResponseByKey('gender');
			$guildMember->level = (int)$response->getResponseByKey('level');
			$guildMember->achievement_points = (int)$response->getResponseByKey('achievementPoints');
			$guildMember->thumbnail = \mb_strtolower(\trim($response->getResponseByKey('thumbnail')));
			$guildMember->last_modified = \date('Y-m-d H:i:s', $lastModified);

			$items = $response->getResponseByKey('items');

			$guildMember->updateItems($items);
			$guildMember->store();
		}
	}

	/**
	 * Updates all guild member information fetched by his/her items.
	 *
	 * @param array $items
	 */
	protected function updateItems(array $items)
	{
		$totalItemLevel = 0;
		$numberOfItemsEquipped = 0;

		$realItemSlots = [
			'head',
			'neck',
			'shoulder',
			'back',
			'chest',
			'wrist',
			'hands',
			'waist',
			'legs',
			'feet',
			'finger1',
			'finger2',
			'trinket1',
			'trinket2',
			'mainHand',
			'offHand',
		];

		foreach ($items as $slotName => $properties) {
			if (!\in_array($slotName, $realItemSlots) || !\array_key_exists('itemLevel', $properties)) {
				continue;
			}

			$totalItemLevel += (int)$properties['itemLevel'];
			$numberOfItemsEquipped++;
		}

		// simulate the off hand if not found as blizzard does it too (simulated double main hand weapon)
		if (!\array_key_exists('offHand', $items) || !\array_key_exists('itemLevel', $items['offHand']) || 0 === (int)$items['offHand']['itemLevel']) {
			// character does not wear an off hand (e.g. restoration druid)
			// character can also wear just an offhand and no main hand (e.g. protection paladin artifact weapon)
			$weaponItemLevel = 0 === (int)$items['offHand']['itemLevel'] ? (int)$items['mainHand']['itemLevel'] : (int)$items['offHand']['itemLevel'];
			$totalItemLevel += $weaponItemLevel;
			$numberOfItemsEquipped++;
		}

		$this->item_level_total = (int)$items['averageItemLevel'];
		$this->item_level_equipped = $numberOfItemsEquipped > 0 ? $totalItemLevel / $numberOfItemsEquipped : 0.0;
	}
}
