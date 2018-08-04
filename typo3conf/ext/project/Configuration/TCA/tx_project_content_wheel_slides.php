<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'Content Wheel Slide',
		'label' => 'title',
		'label_alt' => 'title',
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
		'title' => [
			'label' => 'Title',
			'config' => [
				'type' => 'input',
				'max' => 100,
				'eval' => 'trim,required',
			],
		],
		'bodytext' => [
			'label' => 'Text',
			'config' => [
				'type' => 'text',
				'enableRichtext' => true,
				'eval' => 'trim,required',
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'title',
			'bodytext',
		])],
	],
];
