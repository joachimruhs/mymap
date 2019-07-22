<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}


return array (
	'ctrl' => array(
		'title'	=> 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,address,zipcode,city,country,phone,fax,mobile,email,description,lat,lon,geocode,icon,image,media,categories,',
		'iconfile' => 'EXT:mymap/Resources/Public/Icons/tx_mymap_domain_model_location.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'hidden, name, additionalname, address, additionaladdress, zipcode, city, country, additionalcontact, phone, fax, mobile, email, www, description, kwp, startup, lat, lon, geocode, icon, image, media, images, files, category',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, name, additionalname, address, additionaladdress, zipcode, city, country, additionalcontact, phone, fax, mobile, email, www, description, kwp, startup, lat, lon, geocode, icon, image, media, images, files, category, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'hidden' => array(
			'exclude' => 1,
            'label' => 'LLL:EXT:lang/Resources/Private/Language/locallang_general.xlf:LGL.hidden',			
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
//			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'behaviour' => array (
					'allowLanguageSynchronization' => 1
				),


			),
		),
		'endtime' => array(
			'exclude' => 1,
//			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'renderType' => 'inputDateTime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
				'behaviour' => array (
					'allowLanguageSynchronization' => 1
				),

			),
		),

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'additionalname' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.additionalname',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.address',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'additionaladdress' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.additionaladdress',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

		'zipcode' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.zipcode',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'country' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.country',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

		'additionalcontact' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.additionalcontact',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),


		'phone' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'fax' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.fax',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'mobile' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.mobile',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'www' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.www',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.description',
			'config' => array(
				'type' => 'text',
				'enableRichtext' => true,
				'fieldControl' => [
					'fullScreenRichtext' => [
						'disabled' => false,
					],
				],
			),
	       'defaultExtras' => 'richtext[*]'
		

		),

		'kwp' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.kwp',
			'config' => array(
				'type' => 'input',
				'size' => 6,
				'default' => '0.0',
				'eval' => 'float1'
			),
		),

		'startup' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.startup',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'eval' => 'datetime',
				'renderType' => 'inputDateTime',

				'checkbox' => 0,
				'default' => 0,
				'range' => array(
//					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),

				'behaviour' => array (
					'allowLanguageSynchronization' => 1
				),

			),
		),





		'lat' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.lat',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lon' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.lon',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'geocode' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.geocode',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'default' => 1,
				'eval' => 'int'
			)
		),
		'icon' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.icon',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'icon',
                [
                    'maxitems' => 1,
                    'minitems' => 0,
                    'appearance' => [
                        'collapseAll' => true,
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )


			
		),
		'image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                [
                    'maxitems' => 1,
                    'minitems' => 0,
                    'appearance' => [
                        'collapseAll' => true,
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],
					
					'foreign_types' => [
						'0' => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						]
					],					
					
					
                ],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            )

		),
		'media' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.media',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'media',
                [
                    'maxitems' => 1,
                    'minitems' => 0,
                    'appearance' => [
                        'collapseAll' => true,
                        'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                    ],

					'foreign_types' => [
						'0' => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						]
					],					

                ],
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext']
            )

		),

        'images' => array(
                'exclude' => 1,
                'label' => 'Images',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('images', array(
                        'appearance' => array(
                                'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                        ),
                        'minitems' => 0,
                        'maxitems' => 20,
                ), $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ),
        'files' => array(
                'exclude' => 1,
                'label' => 'Files',
                'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('files', array(
                        'appearance' => array(
                                'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                        ),
					),
				''),
//			  $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']),
        ),


		'category' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_location.category',

			'config' => array(
				'type' => 'select',
				'renderType' => 'selectTree',
				'treeConfig' => array(
				   'parentField' => 'parent',
				   'appearance' => array(
				   'expandAll' => true,
				   'showHeader' => true,
				   ),
				),

				'foreign_table' => 'tx_mymap_domain_model_category',
				'minitems' => 1,
				'maxitems' => 5,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),

			
			
		),


		
		
	),
);
