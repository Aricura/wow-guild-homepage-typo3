<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Class',
		'label' => 'name',
		'label_alt' => 'name',
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
		'foreign_id' => [
			'label' => 'Battle.Net API Id',
			'config' => [
				'type' => 'text',
				'max' => 2,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'mask' => [
			'label' => 'Mask Index',
			'config' => [
				'type' => 'text',
				'max' => 12,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'name' => [
			'label' => 'Class Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'power_type' => [
			'label' => 'Power Type',
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
			'power_type',
			'foreign_id',
			'mask',
		])],
	],
];
