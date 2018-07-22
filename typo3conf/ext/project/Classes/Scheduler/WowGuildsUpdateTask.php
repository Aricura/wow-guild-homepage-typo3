<?php

declare(strict_types=1);

namespace Project\Classes\Scheduler;

use Project\Classes\ContentService\Models\TxWowGuild;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to periodically update/import new World of Warcraft guilds.
 */
class WowGuildsUpdateTask extends AbstractTask
{

	/**
	 * @return int
	 */
	public function execute(): int
	{
		TxWowGuild::seed();

		return 1;
	}
}
