<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Searchform',
	'MYMAP - Search Form'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Autocompleterform',
	'MYMAP - Autocompleter Form'
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Search',
	'MYMAP - Search'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'MapAll',
	'MYMAP - Map with all locations'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Ajaxsearch',
	'MYMAP - Ajaxsearch'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'SingleView',
	'MYMAP - Single View'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'RandomView',
	'MYMAP - Random View'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'AjaxSearch',
	'MYMAP - Ajax Search'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MYMAP');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mymap_domain_model_location', 'EXT:mymap/Resources/Private/Language/locallang_csh_tx_mymap_domain_model_location.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mymap_domain_model_location');


//if (version_compare(TYPO3_branch, '7.0', '>')) 
//$GLOBALS['TCA']['tx_mymap_domain_model_location']['ctrl']['iconfile'] = 'EXT:mymap/Resources/Public/Icons/tx_mymap_domain_model_location.gif';


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mymap_domain_model_category', 'EXT:mymap/Resources/Private/Language/locallang_csh_tx_mymap_domain_model_category.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mymap_domain_model_category');

