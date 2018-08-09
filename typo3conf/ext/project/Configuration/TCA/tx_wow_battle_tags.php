<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Battle Tags',
		'label' => 'battle_tag',
		'label_alt' => 'battle_tag',
		'hideTable' => false,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'dividers2tabs' => true,
		'languageField' => '',
		'enablecolumns' => [
			'disabled' => 'hidden',
		],
		'iconfile' => ExtensionManagementUtility::siteRelPath('core') . 'Resources/Public/Icons/T3Icons/content/content-info.svg',
	],
	'columns' => [
		'hidden' => [
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => [
				'type' => 'check',
				'default' => '0',
			],
		],
		'battle_tag' => [
			'label' => 'Battle Tag',
			'config' => [
				'type' => 'input',
				'max' => 64,
				'eval' => 'trim,required',
			],
		],
		'name' => [
			'label' => 'Name',
			'config' => [
				'type' => 'input',
				'max' => 64,
				'eval' => 'trim,required',
			],
		],
		'tx_wow_guild_members' => [
			'label' => 'Characters',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectMultipleSideBySide',
				'foreign_table' => 'tx_wow_guild_members',
				'foreign_table_where' => 'AND tx_wow_guild_members.deleted = 0 AND tx_wow_guild_members.hidden = 0 ORDER BY tx_wow_guild_members.name ASC',
				'minitems' => 0,
				'maxitems' => 9,
				'multiple' => false,
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'battle_tag',
			'name',
			'tx_wow_guild_members',
		])],
	],
];
