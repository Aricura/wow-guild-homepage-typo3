<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Guild',
		'label' => 'name',
		'label_alt' => 'name',
		'hideTable' => false,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'dividers2tabs' => true,
		'languageField' => 'sys_language_uid',
		'enablecolumns' => [
			'disabled' => 'hidden',
		],
		'iconfile' => ExtensionManagementUtility::siteRelPath('core').'Resources/Public/Icons/T3Icons/content/content-info.svg',
	],
	'columns' => [
		'hidden' => [
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => [
				'type' => 'check',
				'default' => '0',
			],
		],
		'sys_language_uid' => [
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => [
					['LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1],
				],
			],
		],
		'tx_wow_realm_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Realm',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_realms',
				'foreign_table_where' => 'AND tx_wow_realms.deleted = 0 AND tx_wow_realms.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'tx_wow_fraction_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Fraction',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_fraction_uid',
				'foreign_table_where' => 'AND tx_wow_fraction_uid.deleted = 0 AND tx_wow_fraction_uid.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'name' => [
			'label' => 'Guild Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'level' => [
			'label' => 'Level',
			'config' => [
				'type' => 'text',
				'max' => 2,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'achievement_points' => [
			'label' => 'Achievement Points',
			'config' => [
				'type' => 'text',
				'max' => 6,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'name',
			'tx_wow_realm_uid',
			'tx_wow_fraction_uid',
			'level',
			'achievement_points',
		])],
	],
];
