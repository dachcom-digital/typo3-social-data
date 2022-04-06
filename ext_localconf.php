<?php

defined('TYPO3') || die();

call_user_func(static function() {
    
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'SocialData',
        'Pi1',
        [
            \DachcomDigital\SocialData\Controller\WallController::class => 'show',
        ],
        [
            \DachcomDigital\SocialData\Controller\WallController::class => '',
        ]
    );
    
    $logLevel = \TYPO3\CMS\Core\Core\Environment::getContext()->isDevelopment()
        ? \TYPO3\CMS\Core\Log\LogLevel::DEBUG
        : \TYPO3\CMS\Core\Log\LogLevel::WARNING;
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['DachcomDigital']['SocialData']['writerConfiguration'] = [
        $logLevel => [
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                'logFileInfix' => 'socialdata'
            ]
        ],
    ];
});

