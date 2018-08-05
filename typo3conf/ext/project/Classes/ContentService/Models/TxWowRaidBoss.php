<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Typo3ContentService\Models\AbstractModel;

/**
 * Base model representing any record of the tx_wow_raid_bosses table.
 *
 * @property int    uid
 * @property int    pid
 * @property int    tstamp
 * @property int    crdate
 * @property int    cruser_id
 * @property int    sorting
 * @property int    deleted
 * @property int    hidden
 * @property string title
 * @property string first_kill_normal
 * @property string first_kill_heroic
 * @property string first_kill_mythic
 */
class TxWowRaidBoss extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_raid_bosses';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';

	/**
	 * Flag if this boss is slain on any difficulty.
	 *
	 * @return bool
	 */
	public function isSlain(): bool
	{
		return $this->isSlainOnNormal() || $this->isSlainOnHeroic() || $this->isSlainOnMythic();
	}

	/**
	 * Flag if this boss is slain in normal mode.
	 *
	 * @return bool
	 */
	public function isSlainOnNormal(): bool
	{
		return null === $this->first_kill_normal || '' === $this->first_kill_normal;
	}

	/**
	 * Flag if this boss is slain in heroic mode.
	 *
	 * @return bool
	 */
	public function isSlainOnHeroic(): bool
	{
		return null === $this->first_kill_heroic || '' === $this->first_kill_heroic;
	}

	/**
	 * Flag if this boss is slain in mythic mode.
	 *
	 * @return bool
	 */
	public function isSlainOnMythic(): bool
	{
		return null === $this->first_kill_mythic || '' === $this->first_kill_mythic;
	}

	/**
	 * Returns the normal mode first kill date.
	 *
	 * @return \DateTime
	 */
	public function getNormalFirstKillDate(): \DateTime
	{
		return new \DateTime($this->first_kill_normal);
	}

	/**
	 * Returns the heroic mode first kill date.
	 *
	 * @return \DateTime
	 */
	public function getHeroicFirstKillDate(): \DateTime
	{
		return new \DateTime($this->first_kill_normal);
	}

	/**
	 * Returns the mythic mode first kill date.
	 *
	 * @return \DateTime
	 */
	public function getMythicFirstKillDate(): \DateTime
	{
		return new \DateTime($this->first_kill_normal);
	}
}
