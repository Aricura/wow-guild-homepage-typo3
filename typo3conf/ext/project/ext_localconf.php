<?php

use Project\Classes\Scheduler\WowGuildsUpdateTask;
use Project\Classes\Scheduler\WowResourcesUpdateTask;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

$_EXTKEY = 'project';
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:project/config/rte/presets/default.yml';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][WowResourcesUpdateTask::class] = [
	'extension' => $_EXTKEY,
	'title' => 'World of Warcraft Resources Updater',
	'description' => 'Updates / Imports new World of Warcraft resources (battle groups, realms, classes, ...)',
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][WowGuildsUpdateTask::class] = [
	'extension' => $_EXTKEY,
	'title' => 'World of Warcraft Guilds Updater',
	'description' => 'Updates / Imports new World of Warcraft guilds',
];
