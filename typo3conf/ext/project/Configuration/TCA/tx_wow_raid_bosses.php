<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Raid Boss',
		'label' => 'title',
		'label_alt' => 'title',
		'hideTable' => true,
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
		'title' => [
			'label' => 'Raid Boss Name',
			'config' => [
				'type' => 'input',
				'max' => 100,
				'eval' => 'trim,required',
			],
		],
		'first_kill_normal' => [
			'label' => 'Normal First Kill Date',
			'config' => [
				'type' => 'input',
				'eval' => 'date',
				'dbType' => 'date',
			],
		],
		'first_kill_heroic' => [
			'label' => 'Heroic First Kill Date',
			'config' => [
				'type' => 'input',
				'eval' => 'date',
				'dbType' => 'date',
			],
		],
		'first_kill_mythic' => [
			'label' => 'Mythic First Kill Date',
			'config' => [
				'type' => 'input',
				'eval' => 'date',
				'dbType' => 'date',
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'title',
			'first_kill_normal',
			'first_kill_heroic',
			'first_kill_mythic',
		])],
	],
];
