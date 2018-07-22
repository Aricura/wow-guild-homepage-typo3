<?php

declare(strict_types=1);

namespace Project\Classes\ContentService\Api;

use Psr\Http\Message\ResponseInterface;

/**
 * World of Warcraft battle.net API response.
 */
class BattleNetResponse
{

	/**
	 * @var ResponseInterface
	 */
	private $response;

	/**
	 * BattleNetResponse constructor.
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 */
	public function __construct(ResponseInterface $response)
	{
		$this->response = $response;
	}

	/**
	 * Returns the http status code received from the request.
	 *
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return (int)$this->response->getStatusCode();
	}

	/**
	 * Checks if the request was successful or failed.
	 *
	 * @return bool
	 */
	public function success(): bool
	{
		return 200 === $this->getStatusCode();
	}

	/**
	 * Returns the raw response body.
	 *
	 * @return string
	 */
	public function getContent(): string
	{
		return (string)$this->response->getBody();
	}

	/**
	 * Returns the raw response converted to an array.
	 *
	 * @return array
	 */
	public function getResponseArray(): array
	{
		if (!$this->success()) {
			return [];
		}

		return (array)\json_decode($this->getContent(), true);
	}

	/**
	 * Returns the error message if the request failed.
	 *
	 * @return string
	 */
	public function getErrorMessage(): string
	{
		if ($this->success()) {
			return '';
		}

		return $this->getContent();
	}

	/**
	 * Returns the value of the specified root key name if exists or the fallback value on failure.
	 *
	 * @param string $key
	 * @param mixed  $fallback
	 *
	 * @return array|mixed
	 */
	public function getResponseByKey(string $key, $fallback = [])
	{
		$response = $this->getResponseArray();

		return \array_key_exists($key, $response) ? $response[$key] : $fallback;
	}
}
