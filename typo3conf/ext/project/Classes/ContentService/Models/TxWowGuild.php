<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_guilds table.
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
 * @property int tx_wow_realm_uid
 * @property int tx_wow_fraction_uid
 * @property string name
 * @property int level
 * @property int achievement_points
 * @property string last_modified
 */
class TxWowGuild extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'tx_wow_guilds';
}
