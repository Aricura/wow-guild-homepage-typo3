<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_battle_groups');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_realms');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_fractions');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_races');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_classes');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_class_specialisations');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_guilds');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_guild_members');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_raids');
ExtensionManagementUtility::allowTableOnStandardPages('tx_wow_raid_bosses');

ExtensionManagementUtility::allowTableOnStandardPages('tx_project_content_carousel_slides');
ExtensionManagementUtility::allowTableOnStandardPages('tx_project_content_wheel_slides');
