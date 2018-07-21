<?php

declare(strict_types=1);

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
