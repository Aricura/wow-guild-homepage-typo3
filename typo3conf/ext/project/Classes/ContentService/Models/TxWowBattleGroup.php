<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_battle_groups table.
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
 * @property string slug
 * @property string name
 */
class TxWowBattleGroup extends Model
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
		$self = new self();

		return $self->loadBy('slug', \strtolower($slug));
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
		$self = new self();

		return $self->loadBy('name', \trim($name));
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

		foreach($battleGroups as $battleGroup) {
			$model = self::findBySlug($battleGroup['slug']);
			$model->pid = 1;
			$model->cruser_id = 1;
			$model->name = $battleGroup['name'];
			$model->store();
		}
	}
}
