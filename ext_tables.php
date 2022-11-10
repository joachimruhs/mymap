<?php

defined('TYPO3') or die();

$boot = function () {

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mymap_domain_model_location', 'EXT:mymap/Resources/Private/Language/locallang_csh_tx_mymap_domain_model_location.xlf');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mymap_domain_model_location');

	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_mymap_domain_model_category', 'EXT:mymap/Resources/Private/Language/locallang_csh_tx_mymap_domain_model_category.xlf');
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_mymap_domain_model_category');
};
$boot();
unset($boot);
