<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}


return array (
	'ctrl' => array(
		'title'	=> 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_category',
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
		'searchFields' => 'name,description,',
		'iconfile' => 'EXT:mymap/Resources/Public/Icons/tx_mymap_domain_model_category.gif'
	),


	'interface' => array(
		'showRecordFieldList' => 'hidden, name, parent, description',
	),
	'types' => array(
		'1' => array('showitem' => 'hidden, name, parent, description, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
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
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_category.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_category.description',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		
		'parent' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:mymap/Resources/Private/Language/locallang_db.xlf:tx_mymap_domain_model_category.parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', '0'),
				),

				'foreign_table' => 'tx_mymap_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
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
