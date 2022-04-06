<?php

defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'social_data',
    'Pi1',
    'Social Data'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['socialdata_pi1'] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['socialdata_pi1'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'socialdata_pi1',
    'FILE:EXT:social_data/Configuration/FlexForms/Plugin.xml'
);
