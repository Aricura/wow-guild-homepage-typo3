<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Api;

use GuzzleHttp\Client;
use Project\Classes\ContentService\Models\TxWowGuild;

/**
 * wowprogress.com connector.
 */
class WowProgress
{

	/**
	 * @var int
	 */
	private $score = 0;
	/**
	 * @var int
	 */
	private $world_rank = 0;
	/**
	 * @var int
	 */
	private $area_rank = 0;
	/**
	 * @var int
	 */
	private $realm_rank = 0;
	/**
	 * @var string
	 */
	private $url;
	/**
	 * @var TxWowGuild
	 */
	private $guild;

	/**
	 * WowProgress constructor.
	 *
	 * @param TxWowGuild $guild
	 */
	public function __construct(TxWowGuild $guild)
	{
		$this->guild = $guild;

		$url = \sprintf('https://www.wowprogress.com/guild/eu/%s/%s/json_rank', $this->guild->getRealm()->slug, $this->guild->name);
		$this->url = \mb_strtolower(\str_replace(' ', '+', $url));
	}

	/**
	 * @return int
	 */
	public function getScore(): int
	{
		return $this->score;
	}

	/**
	 * @return int
	 */
	public function getWorldRank(): int
	{
		return $this->world_rank;
	}

	/**
	 * @return int
	 */
	public function getAreaRank(): int
	{
		return $this->area_rank;
	}

	/**
	 * @return int
	 */
	public function getRealmRank(): int
	{
		return $this->realm_rank;
	}

	/**
	 * @return \Project\Classes\ContentService\Models\TxWowGuild
	 */
	public function getGuild(): TxWowGuild
	{
		return $this->guild;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return $this->url;
	}

	/**
	 * Fetch the wowprogress.com stats for the specified guild.
	 */
	public function fetch()
	{
		$client = new Client();

		try {
			$response = $client->get($this->url);
			$responseArray = (array)\json_decode((string)$response->getBody(), true);
		} catch (\Exception $exception) {
			return;
		}

		$this->score = \array_key_exists('score', $responseArray) ? (int)$responseArray['score'] : 0;
		$this->world_rank = \array_key_exists('world_rank', $responseArray) ? (int)$responseArray['world_rank'] : 0;
		$this->area_rank = \array_key_exists('area_rank', $responseArray) ? (int)$responseArray['area_rank'] : 0;
		$this->realm_rank = \array_key_exists('realm_rank', $responseArray) ? (int)$responseArray['realm_rank'] : 0;
	}
}
