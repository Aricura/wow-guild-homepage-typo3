<?php

declare(strict_types=1);

namespace Project\Classes\Scheduler;

use TYPO3\CMS\Scheduler\Task\AbstractTask;

/**
 * Scheduler task to periodically update/import new generic World of Warcraft resources.
 */
class WowResourcesUpdateTask extends AbstractTask
{
	/**
	 * @return int
	 */
	public function execute(): int
	{
		return 1;
	}
}
