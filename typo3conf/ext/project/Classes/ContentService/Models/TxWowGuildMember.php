<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Model;

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
 * @property int    sys_language_uid
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
class TxWowGuildMember extends Model
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_guild_members';
}
