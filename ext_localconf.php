<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$_EXTKEY = 'Mymap';

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Searchform',
	[
		\WSR\Mymap\Controller\LocationController::class => 'searchForm',
		
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'searchForm',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Autocompleterform',
	[
		\WSR\Mymap\Controller\LocationController::class => 'autocompleterForm',
		
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'autocompleterForm',
		'Category' => '',
		
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,

);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Search',
	[
				\WSR\Mymap\Controller\LocationController::class => 'search, route',
	],
	// non-cacheable actions
	[
				\WSR\Mymap\Controller\LocationController::class => 'search, route',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'MapAll',
	[
		\WSR\Mymap\Controller\LocationController::class => 'mapAll',
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'mapAll',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'Ajaxsearch',
	[
		\WSR\Mymap\Controller\LocationController::class => 'ajaxSearch',
	],
	// non-cacheable actions
	[

	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'SingleView',
	[
		\WSR\Mymap\Controller\LocationController::class => 'singleView',
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'singleView',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'RandomView',
	[
		\WSR\Mymap\Controller\LocationController::class => 'randomView',
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'randomView',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	$_EXTKEY,
	'AjaxSearch',
	[
		\WSR\Mymap\Controller\LocationController::class => 'ajaxSearch',
	],
	// non-cacheable actions
	[
		\WSR\Mymap\Controller\LocationController::class => 'ajaxSearch',
	],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);

// Plugin for AJAX-calls
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
		$_EXTKEY,
		'Ajax',
		[
			\WSR\Mymap\Controller\AjaxController::class => 'ajaxEid'
		],
		// non-cacheable actions
		[
			\WSR\Mymap\Controller\AjaxController::class => 'ajaxEid'
		],
    ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT,
);




