<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'Searchform',
	array(
		'Location' => 'searchForm',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'searchForm, update, delete',
		'Category' => '',
		
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'Autocompleterform',
	array(
		'Location' => 'autocompleterForm',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'autocompleterForm',
		'Category' => '',
		
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'Search',
	array(
		'Location' => 'search, route, singleView',
		
	),
	// non-cacheable actions
	array(
//		'Location' => 'search, route, singleView, create, update, delete, ',
		'Location' => 'search, route, create, update, delete, ',
		'Category' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'MapAll',
	array(
		'Location' => 'mapAll',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'mapAll',
		'Category' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'Ajaxsearch',
	array(
		'Location' => 'ajaxSearch, route',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'route',
		'Category' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'SingleView',
	array(
		'Location' => 'singleView',
		
	),
	// non-cacheable actions
	array(
//		'Location' => 'singleView',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'RandomView',
	array(
		'Location' => 'randomView',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'randomView',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'WSR.' . $_EXTKEY,
	'AjaxSearch',
	array(
		'Location' => 'ajaxSearch',
		
	),
	// non-cacheable actions
	array(
		'Location' => 'ajaxSearch',
		'Category' => '',
		
	)
);

// Plugin for AJAX-calls
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		'WSR.' . $_EXTKEY,
		'Ajax',
		array(
				'Ajax' => 'ajaxEid'
		),
		// non-cacheable actions
		array(
				'Ajax' => 'ajaxEid'
		)
);




/**
 * Register eID for ajax action-call
 *
 * not used anymore - uses now PSR-15
 */
//$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include']['mymap'] = 'EXT:mymap/Classes/Eid/AjaxBootstrap.php';
