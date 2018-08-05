<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

//<editor-fold desc="Change Fields" defaultstate="collapsed">
$GLOBALS['TCA']['tt_content']['columns']['subheader']['config']['type'] = 'text';
$GLOBALS['TCA']['tt_content']['columns']['subheader']['config']['rows'] = '1';
$GLOBALS['TCA']['tt_content']['columns']['subheader']['config']['cols'] = '30';

$GLOBALS['TCA']['tt_content']['columns']['image']['l10n_mode'] = 'exclude';
$GLOBALS['TCA']['tt_content']['columns']['image']['config']['minitems'] = 0;
$GLOBALS['TCA']['tt_content']['columns']['image']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tt_content']['columns']['image']['config']['appearance']['fileUploadAllowed'] = false;

$GLOBALS['TCA']['tt_content']['columns']['media']['config']['maxitems'] = 1;
$GLOBALS['TCA']['tt_content']['columns']['media']['config']['appearance']['fileUploadAllowed'] = false;

$GLOBALS['TCA']['tt_content']['columns']['bodytext']['config']['enableRichtext'] = true;
//</editor-fold>

//<editor-fold desc="Add Fields" defaultstate="collapsed">
$fields = [
	'tx_project_content_carousel_slides' => [
		'label' => 'Content Carousel Items',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_project_content_carousel_slides',
			'foreign_field' => 'parent_id',
			'foreign_table_field' => 'parent_table',
			'minitems' => 0,
			'maxitems' => 99,
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
	'tx_project_image_square' => [
		'exclude' => 1,
		'label' => 'Image (square)',
		'config' => ExtensionManagementUtility::getFileFieldTCAConfig('tx_project_image_square', [
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
								'square' => [
									'title' => 'Square',
									'allowedAspectRatios' => [
										'1:1' => [
											'title' => '1:1',
											'value' => 1 / 1,
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
	'tx_project_content_wheel_slides' => [
		'label' => 'Content Wheel Items',
		'config' => [
			'type' => 'inline',
			'foreign_table' => 'tx_project_content_wheel_slides',
			'foreign_field' => 'parent_id',
			'foreign_table_field' => 'parent_table',
			'minitems' => 3,
			'maxitems' => 6,
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
	'tx_wow_raids' => [
		'label' => 'Raids',
		'config' => [
			'type' => 'select',
			'foreign_table' => 'tx_wow_raids',
			'foreign_table_where' => '',
			'minitems' => 2,
			'maxitems' => 3,
			'multiple' => false,
		],
	],
];

ExtensionManagementUtility::addTCAcolumns('tt_content', $fields);
//</editor-fold>

//<editor-fold desc="Function: Add Plugin" defaultstate="collapsed">
$addPlugin = function (string $name, string $identifier, array $fields) {
	$key = 'project_'.$identifier;
	$icon = 'content-text';

	ExtensionManagementUtility::addPlugin([$name, $key, $icon], 'CType', 'project');

	$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$key] = $icon;
	$GLOBALS['TCA']['tt_content']['types'][$key] = ['showitem' => \implode(',', $fields)];
};
//</editor-fold>

//<editor-fold desc="Plugin: Content Carousel" defaultstate="collapsed">
$addPlugin('Content Carousel', 'content_carousel', [
	'CType',
	'tx_project_content_carousel_slides',
]);
//</editor-fold>

//<editor-fold desc="Plugin: Content Wheel" defaultstate="collapsed">
$addPlugin('Content Wheel', 'content_wheel', [
	'CType',
	'header',
	'tx_project_image_square;Wheel Image (square)',
	'tx_project_content_wheel_slides',
]);
//</editor-fold>

//<editor-fold desc="Plugin: Raid Progression" defaultstate="collapsed">
$addPlugin('Raid Progression', 'raid_progression', [
	'CType',
	'tx_wow_raids',
]);
//</editor-fold>
