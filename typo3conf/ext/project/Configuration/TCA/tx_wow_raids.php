<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Raid',
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
			'label' => 'Raid Name',
			'config' => [
				'type' => 'input',
				'max' => 100,
				'eval' => 'trim,required',
			],
		],
		'image' => [
			'exclude' => 1,
			'label' => 'Background Image',
			'config' => ExtensionManagementUtility::getFileFieldTCAConfig('image', [
				'minitems' => 1,
				'maxitems' => 1,
				'appearance' => [
					'fileUploadAllowed' => false,
				],
				'overrideChildTca' => [
					'columns' => [
						'crop' => [
							'config' => [
								'cropVariants' => [
									'default' => [
										'title' => 'Default',
										'allowedAspectRatios' => [
											'3:2' => [
												'title' => '3:2',
												'value' => 3 / 2,
											],
										],
									],
								],
							],
						],
					],
					'types' => [
						File::FILETYPE_IMAGE => [
							'showitem' => '
                                    --palette--;LLL:EXT:lang/Resources/Private/Language/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
						],
					],
				],
			], 'jpg,jpeg,png'),
		],
		'tx_wow_raid_bosses' => [
			'label' => 'Raid Bosses',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_wow_raid_bosses',
				'foreign_field' => 'parent_id',
				'foreign_table_field' => 'parent_table',
				'minitems' => 1,
				'maxitems' => 19,
				'appearance' => [
					'useSortable' => true,
					'collapseAll' => true,
					'expandSingle' => true,
					'newRecordLinkAddTitle' => false,
					'showPossibleLocalizationRecords' => true,
					'showAllLocalizationLink' => true,
				],
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'title',
			'image',
			'tx_wow_raid_bosses',
		])],
	],
];
