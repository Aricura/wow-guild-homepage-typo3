<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Realm',
		'label' => 'name',
		'label_alt' => 'name',
		'hideTable' => false,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'name',
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
		'tx_wow_battle_group_uid' => [
			'label' => 'Battle Group',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_wow_battle_groups',
				'foreign_table_where' => 'AND tx_wow_battle_groups.deleted = 0 AND tx_wow_battle_groups.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'slug' => [
			'label' => 'Slug (unique)',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'name' => [
			'label' => 'Realm Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'type' => [
			'label' => 'Type (PVE, PVP, RP, ...)',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'population' => [
			'label' => 'Population Index (low, medium, high)',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'locale' => [
			'label' => 'Localization (en_GB)',
			'config' => [
				'type' => 'text',
				'max' => 8,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'name',
			'tx_wow_battle_group_uid',
			'slug',
			'type',
			'population',
			'locale',
		])],
	],
];
