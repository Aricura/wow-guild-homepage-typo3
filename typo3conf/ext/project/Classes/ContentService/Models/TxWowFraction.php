<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Models;

use Project\Classes\ContentService\Model;

/**
 * Base model representing any record of the tx_wow_fractions table.
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
 */
class TxWowFraction extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'tx_wow_fractions';

	/**
	 * Fetches a single fraction model by its unique slug.
	 *
	 * @param string $slug
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function findBySlug(string $slug): self
	{
		$self = new self();

		return $self->loadBy('slug', \strtolower($slug));
	}

	/**
	 * Returns the alliance fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getAlliance(): self
	{
		$self = new self();

		return $self->findBySlug('alliance');
	}

	/**
	 * Returns the horde fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getHorde(): self
	{
		$self = new self();

		return $self->findBySlug('horde');
	}

	/**
	 * Returns the neutral fraction model.
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function getNeutral(): self
	{
		$self = new self();

		return $self->findBySlug('neutral');
	}

	/**
	 * Fetches a single fraction model by its unique index.
	 *
	 * @param int $index
	 *
	 * @return \Project\Classes\ContentService\Models\TxWowFraction
	 */
	public static function findByIndex(int $index): self
	{
		switch($index) {
			case 0:
			default:
				return self::getAlliance();
			case 1:
				return self::getHorde();
			case 2:
				return self::getNeutral();
		}
	}

	/**
	 * Seeds the World of Warcraft fraction database table.
	 */
	public static function seed()
	{
		self::getAlliance()->store();
		self::getHorde()->store();
		self::getNeutral()->store();
	}
}
