<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\Helper\CropImage;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use Typo3ContentService\Models\AbstractModel;

/**
 * Base model representing any record of the tx_wow_raids table.
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
 * @property int    image
 * @property int    tx_wow_raid_bosses
 */
class TxWowRaid extends AbstractModel
{

	/**
	 * @var string
	 */
	protected $table = 'tx_wow_raids';
	/**
	 * Column name where the language index of the model is stored in.
	 * This information may be empty if the model has no language index / isn't translatable.
	 * Default set to 'sys_language_uid'.
	 *
	 * @var string
	 */
	protected $languageIndexColumnName = '';
	/**
	 * @var array|TxWowRaidBoss[]
	 */
	private $raidBossesCached;

	/**
	 * @return \TYPO3\CMS\Core\Resource\ProcessedFile
	 */
	public function getImage(): ProcessedFile
	{
		$image = $this->resolveFile('image');

		return CropImage::getProcessedFile($image, 'default');
	}

	/**
	 * Returns all raid bosses of this raid.
	 *
	 * @return array|TxWowRaidBoss[]
	 */
	public function getRaidBosses(): array
	{
		if (!$this->raidBossesCached) {
			$where = [
				'parent_id' => $this->getKey(),
				'parent_table' => $this->getTableName(),
			];

			$this->raidBossesCached = TxWowRaidBoss::findAllBy($where);
		}

		return $this->raidBossesCached;
	}

	/**
	 * Returns the number of boss kills on normal difficulty.
	 *
	 * @return int
	 */
	public function getNormalBossKills(): int
	{
		$kills = 0;

		foreach ($this->getRaidBosses() as $raidBoss) {
			if ($raidBoss->isSlainOnNormal()) {
				$kills++;
			}
		}

		return $kills;
	}

	/**
	 * Returns the number of boss kills on heroic difficulty.
	 *
	 * @return int
	 */
	public function getHeroicBossKills(): int
	{
		$kills = 0;

		foreach ($this->getRaidBosses() as $raidBoss) {
			if ($raidBoss->isSlainOnHeroic()) {
				$kills++;
			}
		}

		return $kills;
	}

	/**
	 * Returns the number of boss kills on mythic difficulty.
	 *
	 * @return int
	 */
	public function getMythicBossKills(): int
	{
		$kills = 0;

		foreach ($this->getRaidBosses() as $raidBoss) {
			if ($raidBoss->isSlainOnMythic()) {
				$kills++;
			}
		}

		return $kills;
	}

	/**
	 * Flag if normal mode is cleared or not.
	 *
	 * @return bool
	 */
	public function isNormalClear(): bool
	{
		return $this->getNormalBossKills() === \count($this->getRaidBosses());
	}

	/**
	 * Flag if heroic mode is cleared or not.
	 *
	 * @return bool
	 */
	public function isHeroicClear(): bool
	{
		return $this->getHeroicBossKills() === \count($this->getRaidBosses());
	}

	/**
	 * Flag if mythic mode is cleared or not.
	 *
	 * @return bool
	 */
	public function isMythicClear(): bool
	{
		return $this->getMythicBossKills() === \count($this->getRaidBosses());
	}
}
