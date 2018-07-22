<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Api\BattleNet;
use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_realms table.
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
 * @property int tx_wow_battle_group_uid
 * @property string slug
 * @property string name
 * @property string type
 * @property string population
 * @property string locale
 */
class TxWowRealm extends Model
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
		$self = new self();

		return $self->loadBy('slug', \strtolower($slug));
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

		foreach($realms as $realm) {
			$battleGroup = TxWowBattleGroup::findBySlug($realm['battlegroup']);
			if (!$battleGroup->exists()) {
				$battleGroup = TxWowBattleGroup::findByName($realm['battlegroup']);
			}

			$model = self::findBySlug($realm['slug']);
			$model->pid = 1;
			$model->cruser_id = 1;
			$model->tx_wow_battle_group_uid = $battleGroup->getKey();
			$model->name = $realm['name'];
			$model->type = \strtolower($realm['type']);
			$model->population = \strtolower($realm['population']);
			$model->locale = $realm['locale'];
			$model->store();
		}
	}
}
