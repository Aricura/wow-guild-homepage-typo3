<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Race',
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
		'tx_wow_fraction_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Fraction',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_wow_fractions',
				'foreign_table_where' => 'AND tx_wow_fractions.deleted = 0 AND tx_wow_fractions.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
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
			'label' => 'Race Name',
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
			'tx_wow_fraction_uid',
			'foreign_id',
			'mask',
		])],
	],
];
