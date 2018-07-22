<?php

declare(strict_types=1);

namespace Project\Classes\Helper;

/**
 * Extension configuration helper class.
 */
class Config
{

	/**
	 * Caches all configuration values previously read.
	 *
	 * @var array
	 */
	private static $cache = [];

	/**
	 * Returns the project extension configuration value of the specified key name or the fallback if not found.
	 *
	 * @param string $configKeyName
	 * @param string $fallback
	 *
	 * @return mixed|string
	 */
	public static function get(string $configKeyName, $fallback = '')
	{
		if (!\count(self::$cache)) {
			$extensionConfigString = (string) $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['project'];

			self::$cache = \unserialize($extensionConfigString, ['allowed_classes' => true]);

			if (!\is_array(self::$cache)) {
				self::$cache = [];
			}
		}

		return \array_key_exists($configKeyName, self::$cache) ? self::$cache[$configKeyName] : $fallback;
	}
}
