<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Api;

use GuzzleHttp\Client;
use Project\Classes\Helper\Config;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
	const BASE_URL = 'https://eu.api.blizzard.com/wow/';
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
		$this->clientId = (string)Config::get('battle_net_api_client_id');
		$this->secret = (string)Config::get('battle_net_api_secret');
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
			/** @var Logger $logger */
			$logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
			$logger->error('Battle.net API Exception: '.$exception->getMessage());
			return new BattleNetResponse(null, $exception->getMessage());
		}
	}
}
