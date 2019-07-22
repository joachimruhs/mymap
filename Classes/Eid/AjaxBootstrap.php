<?php

namespace WSR\mymap\Eid;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Service\TypoScriptService;

/**
 * This class could called via eID
 */
class AjaxBootstrap {
	
	/**
   * @var \array
   */
	protected $configuration;
	
	/**
   * @var \array
   */
	protected $bootstrap;
	
	/**
   * The main Method
   *
   * @return \string
   */
	public function run() {
		return $this->bootstrap->run( '', $this->configuration );
	}
	
	/**
   * Initialize Extbase
   *
   * @param \array $TYPO3_CONF_VARS
   */
	public function __construct($TYPO3_CONF_VARS) {

	
		if (! $_POST['tx_mymap_ajax']['action']) { // set default action, if not set
			$_POST['tx_mymap_ajax']['action'] = 'ajaxEid';
		}

		$_POST['tx_mymap_ajax']['controller'] = 'Ajax'; // set controller
		
		// create bootstrap
		$this->bootstrap = new \TYPO3\CMS\Extbase\Core\Bootstrap();
		

		// get User
		$feUserObj = \TYPO3\CMS\Frontend\Utility\EidUtility::initFeUser();

		// set PID
		$pid = (GeneralUtility::_GET( 'id' )) ? GeneralUtility::_GET( 'id' ) : 1;
		
// J. Ruhs
// Fehler bei initTemplate()
//echo '********' . GeneralUtility::_GET( 'id' );
//$pid = 43; //$_POST['id'];

		// Create and init Frontend
		$GLOBALS['TSFE'] = GeneralUtility::makeInstance( 'TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $TYPO3_CONF_VARS, $pid, 0, TRUE );
		$GLOBALS['TSFE']->connectToDB();
		$GLOBALS['TSFE']->fe_user = $feUserObj;
		$GLOBALS['TSFE']->id = $pid;
		$GLOBALS['TSFE']->determineId();
//		$GLOBALS['TSFE']->getCompressedTCarray();
		$GLOBALS['TSFE']->initTemplate();
		$GLOBALS['TSFE']->getConfigArray();
//		$GLOBALS['TSFE']->includeTCA();
		\TYPO3\CMS\Frontend\Utility\EidUtility::initTCA();
		
		// Get Plugins TypoScript
//		$TypoScriptService = new \TYPO3\CMS\Extbase\Service\TypoScriptService();
//		$pluginConfiguration = $TypoScriptService->convertTypoScriptArrayToPlainArray($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_mymap.']);

// for TYPO3 8.7
		$pluginConfiguration = $this->convertTypoScriptArrayToPlainArray($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_mymap.']);

		
		// Set configuration to call the plugin
		$this->configuration = array (
				'pluginName' => 'Ajax',
				'vendorName' => 'WSR',
				'extensionName' => 'Mymap',
				'controller' => 'Ajax',
				'action' => $_POST['tx_mymap_ajax']['action'],
				'mvc' => array (
						'requestHandlers' => array (
								'TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler' => 'TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler'
						)
				),
				'settings' => $pluginConfiguration['settings'],
				'persistence' => array (
						'storagePid' => $pluginConfiguration['persistence']['storagePid']
				)
		);

	}


    /**
     * Removes all trailing dots recursively from TS settings array
     *
     * Extbase converts the "classical" TypoScript (with trailing dot) to a format without trailing dot,
     * to be more future-proof and not to have any conflicts with Fluid object accessor syntax.
     *
     * @param array $typoScriptArray The TypoScript array (e.g. array('foo' => 'TEXT', 'foo.' => array('bar' => 'baz')))
     * @return array e.g. array('foo' => array('_typoScriptNodeValue' => 'TEXT', 'bar' => 'baz'))
     * @api
     */
    public function convertTypoScriptArrayToPlainArray(array $typoScriptArray)
    {
        foreach ($typoScriptArray as $key => $value) {
            if (substr($key, -1) === '.') {
                $keyWithoutDot = substr($key, 0, -1);
                $typoScriptNodeValue = isset($typoScriptArray[$keyWithoutDot]) ? $typoScriptArray[$keyWithoutDot] : null;
                if (is_array($value)) {
                    $typoScriptArray[$keyWithoutDot] = $this->convertTypoScriptArrayToPlainArray($value);
                    if (!is_null($typoScriptNodeValue)) {
                        $typoScriptArray[$keyWithoutDot]['_typoScriptNodeValue'] = $typoScriptNodeValue;
                    }
                    unset($typoScriptArray[$key]);
                } else {
                    $typoScriptArray[$keyWithoutDot] = null;
                }
            }
        }
        return $typoScriptArray;
    }





}

global $TYPO3_CONF_VARS;

// make instance of bootstrap and run
$eid = GeneralUtility::makeInstance( 'WSR\mymap\Eid\AjaxBootstrap', $TYPO3_CONF_VARS );
echo $eid->run();
?>