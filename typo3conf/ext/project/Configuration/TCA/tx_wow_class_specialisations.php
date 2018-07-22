<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Class Specialisation',
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
		'tx_wow_class_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Class',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_classes',
				'foreign_table_where' => 'AND tx_wow_classes.deleted = 0 AND tx_wow_classes.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'name' => [
			'label' => 'Specialisation Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'background_image' => [
			'label' => 'Background Image',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'icon' => [
			'label' => 'Icon',
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
			'tx_wow_class_uid',
			'background_image',
			'icon',
		])],
	],
];
