<?php

$ll = 'LLL:EXT:social_data/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_socialdata_domain_model_post',
        'descriptionColumn' => '',
        'label' => 'title',
        'prependAtCopy' => '',
        'hideAtCopy' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => false,
        'type' => 'type',
        'typeicon_column' => 'type',
        'typeicon_classes' => [
            'default' => 'mimetypes-x-content-text-picture'
        ],
        'useColumnsForDefaultValues' => 'type',
        'default_sortby' => 'ORDER BY datetime DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden'
        ],
        'iconfile' => 'EXT:social_data/Resources/Public/Icons/tx_socialdata_domain_model_post.svg',
        'searchFields' => 'uid,title',
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
        'type' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.type',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'readOnly' => true
            ]
        ],
        'social_id' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.social_id',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'readOnly' => true
            ]
        ],
        'datetime' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.datetime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 16,
                'eval' => 'datetime',
                'readOnly' => true
            ]
        ],
        'title' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.title',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'max' => 255,
                'readOnly' => true
            ]
        ],
        'content' => [
            'exclude' => true,
            'label' => $ll . 'tx_socialdata_domain_model_post.content',
            'config' => [
                'type' => 'text',
                'cols' => 60,
                'rows' => 5,
                'readOnly' => true
            ]
        ],
        'url' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.url',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'readOnly' => true
            ]
        ],
        'media_url' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.media_url',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'readOnly' => true
            ]
        ],
        'poster_url' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.poster_url',
            'config' => [
                'type' => 'input',
                'size' => 60,
                'readOnly' => true
            ]
        ],
        'poster' => [
            'exclude' => false,
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.media',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'poster',
                [
                    'readOnly' => true,
                    'maxitems' => 1,
                    // Use the imageoverlayPalette instead of the basicoverlayPalette
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette',
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                    --palette--;;imageoverlayPalette,
                                    --palette--;;filePalette',
                            ]
                        ],
                    ]
                ]
            )
        ],
        'feed' => [
            'exclude' => false,
            'label' => $ll . 'tx_socialdata_domain_model_post.feed',
            'config' => [
                'type' => 'passthrough'
            ]
        ]
    ],
    'types' => [
        // default
        '0' => [
            'showitem' => '
                    type,
                    social_id,
                    datetime,
                    title,
                    content,
                    url,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
                    media_url,
                    poster_url,
                    poster,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;paletteHidden
                '
        ]
    ]
];
