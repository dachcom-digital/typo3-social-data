<?php

$ll = 'LLL:EXT:social_data/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_socialdata_domain_model_wall',
        'descriptionColumn' => '',
        'label' => 'name',
        'prependAtCopy' => '',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => false,
        'origUid' => 't3_origuid',
        'editlock' => 'editlock',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
            'fe_group' => 'fe_group',
        ],
        'typeicon_classes' => [
            'default' => 'actions-viewmode-photos'
        ],
        'iconfile' => 'EXT:social_data/Resources/Public/Icons/tx_socialdata_domain_model_wall.svg',
        'searchFields' => 'uid,name',
    ],
    'columns' => [
        'cruser_id' => [
            'label' => 'cruser_id',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'pid' => [
            'label' => 'pid',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'crdate' => [
            'label' => 'crdate',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ]
        ],
        'tstamp' => [
            'label' => 'tstamp',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime',
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    ['', '']
                ],
            ]
        ],
        'name' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_wall.name',
            'config' => [
                'type' => 'input',
                'size' => 255
            ]
        ],
        'feeds' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_wall.feeds',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_socialdata_domain_model_feed',
                'MM' => 'tx_socialdata_wall_feed',
            ]
        ],
        'categories' => [
            'config' => [
                'type' => 'category'
            ]
        ]
    ],
    'types' => [
        // default
        '0' => [
            'showitem' => '
                    name,
                    feeds,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden
                '
        ]
    ]
];
