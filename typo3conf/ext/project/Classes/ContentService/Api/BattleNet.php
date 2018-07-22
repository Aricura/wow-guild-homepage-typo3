<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Api;

use GuzzleHttp\Client;

/**
 * World of Warcraft battle.net API connector.
 */
class BattleNet
{

	/**
	 * Base url to fetch any battle.net data.
	 *
	 * @var string
	 */
	const BASE_URL = 'https://eu.api.battle.net/wow/';
	/**
	 * @var string
	 */
	private $clientId;
	/**
	 * @var string
	 */
	private $secret;

	/**
	 * BattleNet constructor.
	 */
	public function __construct()
	{
		$this->clientId = (string)$GLOBALS['API']['battle.net']['client_id'];
		$this->secret = (string)$GLOBALS['API']['battle.net']['secret'];
	}

	/**
	 * Fetches all data from the specified battle.net API path.
	 *
	 * @param string $path   relative API path to fetch all data
	 * @param array  $params optional additional parameters sent
	 * @param string $locale optional locale to translate the response (default en_GB)
	 *
	 * @return \Project\Classes\ContentService\Api\BattleNetResponse
	 */
	public function get(string $path, array $params = [], string $locale = 'en_GB'): BattleNetResponse
	{
		$url = \sprintf(
			'%s/%s?locale=%s&apikey=%s',
			\trim(self::BASE_URL, '/'),
			\ltrim($path, '/'),
			$locale,
			$this->clientId
		);

		if (\count($params) > 0) {
			foreach ($params as $key => $value) {
				$url .= \sprintf('&%s=%s', \trim($key), \trim($value));
			}
		}

		$client = new Client();

		try {
			return new BattleNetResponse($client->get($url));
		} catch (\Exception $exception) {
			return null;
		}
	}
}
