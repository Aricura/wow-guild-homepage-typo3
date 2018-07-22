<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

if (!\defined('TYPO3_MODE')) {
	die('Access denied.');
}

return [
	'ctrl' => [
		'title' => 'World of Warcraft Guild',
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
		'iconfile' => ExtensionManagementUtility::siteRelPath('core').'Resources/Public/Icons/T3Icons/content/content-info.svg',
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
		'tx_wow_guild_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Guild',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_guilds',
				'foreign_table_where' => 'AND tx_wow_guilds.deleted = 0 AND tx_wow_guilds.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'tx_wow_realm_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Realm',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_realms',
				'foreign_table_where' => 'AND tx_wow_realms.deleted = 0 AND tx_wow_realms.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'tx_wow_race_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Race',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_races',
				'foreign_table_where' => 'AND tx_wow_races.deleted = 0 AND tx_wow_races.hidden = 0',
				'minitems' => 1,
				'maxitems' => 1,
				'multiple' => false,
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
		'tx_wow_class_specialisation_uid' => [
			'displayCond' => 'FIELD:sys_language_uid:<=:0',
			'label' => 'Specialisation',
			'config' => [
				'type' => 'select',
				'foreign_table' => 'tx_wow_class_specialisations',
				'foreign_table_where' => 'AND tx_wow_class_specialisations.deleted = 0 AND tx_wow_class_specialisations.hidden = 0',
				'minitems' => 0,
				'maxitems' => 1,
				'multiple' => false,
			],
		],
		'guild_rank' => [
			'label' => 'Guild Rank',
			'config' => [
				'type' => 'text',
				'max' => 2,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'gender' => [
			'label' => 'Gender',
			'config' => [
				'type' => 'select',
				'items' => [
					['Female', 0],
					['Male', 1],
				]
			],
		],
		'name' => [
			'label' => 'Character Name',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'level' => [
			'label' => 'Level',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'achievement_points' => [
			'label' => 'Achievement Points',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'thumbnail' => [
			'label' => 'Thumbnail',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'item_level_equipped' => [
			'label' => 'Item Level (equipped)',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'item_level_total' => [
			'label' => 'Item Level (total, including Bag/Bank)',
			'config' => [
				'type' => 'text',
				'max' => 255,
				'eval' => 'trim,required',
				'rows' => 1,
			],
		],
		'is_raid_member' => [
			'label' => 'Is Raid Member?',
			'config' => [
				'type' => 'check',
				'default' => 0,
			],
		],
	],
	'types' => [
		'0' => ['showitem' => \implode(',', [
			'name',
			'tx_wow_guild_uid',
			'tx_wow_realm_uid',
			'tx_wow_race_uid',
			'tx_wow_class_uid',
			'guild_rank',
			'gender',
			'level',
			'achievement_points',
			'thumbnail',
			'--div--;Raid',
			'is_raid_member',
			'tx_wow_class_specialisation_uid',
			'item_level_equipped',
			'item_level_total',
		])],
	],
];