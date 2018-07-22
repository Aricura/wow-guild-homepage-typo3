<?php

declare(strict_types=1);

namespace Project\Classes\Scheduler;

use Project\Classes\ContentService\Models\TxWowGuildMember;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to periodically update/import new World of Warcraft guilds.
 */
class WowGuildMembersUpdateTask extends AbstractTask
{

	/**
	 * @return int
	 */
	public function execute(): int
	{
		TxWowGuildMember::seed();

		return 1;
	}
}
