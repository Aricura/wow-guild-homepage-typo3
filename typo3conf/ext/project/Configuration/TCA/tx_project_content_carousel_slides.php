<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'Content Carousel Slide',
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
				'max' => 255,
				'rows' => 4,
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
									'portrait' => [
										'title' => 'Portrait',
										'allowedAspectRatios' => [
											'1:2' => [
												'title' => '1:2',
												'value' => 1 / 2,
											],
										],
									],
									'landscape' => [
										'title' => 'Landscape',
										'allowedAspectRatios' => [
											'16:9' => [
												'title' => '16:9',
												'value' => 16 / 9,
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
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'title',
			'bodytext',
			'image',
		])],
	],
];
