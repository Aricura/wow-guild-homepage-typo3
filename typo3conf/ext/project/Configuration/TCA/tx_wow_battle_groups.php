<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Battle Group',
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
			'label' => 'Battle Group Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'name',
			'slug',
		])],
	],
];
