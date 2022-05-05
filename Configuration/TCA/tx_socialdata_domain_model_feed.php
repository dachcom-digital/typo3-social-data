<?php

$ll = 'LLL:EXT:social_data/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_socialdata_domain_model_feed',
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
            'disabled' => 'hidden'
        ],
        'typeicon_classes' => [
            'default' => 'actions-window-cog'
        ],
        'iconfile' => 'EXT:social_data/Resources/Public/Icons/tx_socialdata_domain_model_feed.svg',
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
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ]
        ],
        'name' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_feed.name',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'eval' => 'trim,required'
            ]
        ],
        'storage_pid' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_feed.storage_pid',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'pages',
                'maxitems' => 1,
                'minitems' => 0,
                'size' => 1,
                'default' => 0,
                'suggestOptions' => [
                    'default' => [
                        'andWhere' => 'pages.doktype = 254'
                    ]
                ],
                'eval' => 'required'
            ]
        ],
        'persist_media' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_feed.persist_media',
            'description' => $ll . 'tx_socialdata_domain_model_feed.persist_media.description',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ]
            ]
        ],
        'connector_identifier' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_feed.connector',
            'onChange' => 'reload',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', '']
                ],
                'itemsProcFunc' => sprintf('%s->getOptions', \DachcomDigital\SocialData\FormEngine\DataProvider\SelectConnectorsDataProvider::class)
            ]
        ],
        'connector_configuration' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_feed.connector_configuration',
            'config' => [
                'type' => 'flex',
                'ds_pointerField' => 'connector_identifier',
                'ds' => [
                    'default' => 'FILE:EXT:social_data/Configuration/FlexForms/EmptyConnectorConfiguration.xml'
                ]
            ]
        ],
        'connector_status' => [
            'label' => $ll . 'tx_socialdata_domain_model_feed.connector_status',
            'displayCond' => 'FIELD:connector_identifier:REQ:true',
            'config' => [
                'type' => 'none',
                'renderType' => \DachcomDigital\SocialData\FormEngine\Element\AbstractConnectorStatusElement::NODE_NAME
            ]
        ],
        'access_token' => [
            'label' => 'access token',
            'config' => [
                'type' => 'passthrough'
            ]
        ],
        'categories' => [
            'config' => [
                'type' => 'category'
            ]
        ],
        'posts' => [
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_socialdata_domain_model_post',
                'foreign_field' => 'feed',
                'readOnly' => true
            ]
        ]
    ],
    'types' => [
        // default
        '0' => [
            'showitem' => '
                    name,
                    storage_pid, persist_media,
                    connector_identifier,
                    connector_configuration,
                    connector_status,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden
                '
        ]
    ]
];
