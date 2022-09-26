<?php
namespace WSR\Mymap\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\EventDispatcher\EventDispatcherInterface;

/***
 *
 * This file is part of the "Mymap" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
 *
 ***/

/**
 * LocationController
 */
class LocationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
	 */
	protected $feUserRepository;
 
    /**
     * Inject a frontendUserRepository to enable DI
     *
     * @param \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $feUserRepository
     * @return void
     */
    public function injectFrontendUserRepository(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository $feUserRepository) {
        $this->feUserRepository = $feUserRepository;
    }


	/**
	 * locationRepository
	 * 
	 * @var \WSR\Mymap\Domain\Repository\LocationRepository
	 */
	protected $locationRepository = NULL;


    /**
     * Inject a locationRepository to enable DI
     *
     * @param \WSR\Mymap\Domain\Repository\LocationRepository $locationRepository
     * @return void
     */
    public function injectLocationRepository(\WSR\Mymap\Domain\Repository\LocationRepository $locationRepository) {
        $this->locationRepository = $locationRepository;
    }






	/**
	 * categoryRepository
	 *
	 * @var \WSR\Mymap\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;


    /**
     * Inject a categoryRepository to enable DI
     *
     * @param \WSR\Mymap\Domain\Repository\CategoryRepository $categoryRepository
     * @return void
     */
    public function injectCategoryRepository(\WSR\Mymap\Domain\Repository\CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }




	 public function initializeObject() {
//		$this->_GP = $this->request->getArguments();
      	$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->conf['storagePid'] = $configuration['persistence']['storagePid'];

//$querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
//$querySettings->setRespectStoragePage(FALSE);
// $querySettings->setStoragePageIds(array(1, 26, 989));

     }
 

	/**
	 * action list
	 * 
	 * @return void
	 */
	public function listAction() {
		$locations = $this->locationRepository->findAll();
		$this->view->assign('locations', $locations);
		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);
	}

	/**
	 * action show
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $location
	 * @return void
	 */
	public function showAction(\WSR\Mymap\Domain\Model\Location $location) {
		$this->view->assign('location', $location);
	}

	/**
	 * action new
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $newLocation
	 * @return void
	 */
	public function newAction(\WSR\Mymap\Domain\Model\Location $newLocation = NULL) {
		$this->view->assign('newLocation', $newLocation);
	}

	/**
	 * action create
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $newLocation
	 * @return void
	 */
	public function createAction(\WSR\Mymap\Domain\Model\Location $newLocation) {
		$this->addFlashMessage('This function is deactivated for security reasons!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
//		$this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See <a href="http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain" target="_blank">Wiki</a>', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
//		$this->locationRepository->add($newLocation);
		$this->redirect('searchForm');
	}

	/**
	 * action edit
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $location
	 * @return void
	 */
	public function editAction(\WSR\Mymap\Domain\Model\Location $location) {
		$this->view->assign('location', $location);
	}

	/**
	 * action update
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $location
	 * @return void
	 */
	public function updateAction(\WSR\Mymap\Domain\Model\Location $location) {
		$this->addFlashMessage('This function is deactivated for security reasons!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
//		$this->locationRepository->update($location);
		$this->redirect('searchForm');
	}

	/**
	 * action delete
	 * 
	 * @param \WSR\Mymap\Domain\Model\Location $location
	 * @return void
	 */
	public function deleteAction(\WSR\Mymap\Domain\Model\Location $location) {
		$this->addFlashMessage('This function is deactivated for security reasons!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
//		$this->locationRepository->remove($location);
		$this->redirect('searchForm');
	}

	/**

	 * action singleView

	 * 

	 * @return void

	 */
	public function singleViewAction() {
		$this->_GP = $this->request->getArguments();

		if ($this->_GP['locationUid']) {// called from list link
			$location = $this->locationRepository->findLocationUidOverride(intval($this->_GP['locationUid']));
			$this->view->assign('category', $this->categoryRepository->findCategoriesByLocation(intval($this->_GP['locationUid'])));
		}
		else {
//			$location = $this->locationRepository->findByUid(intval($this->settings['singleViewUid']));
			$this->view->assign('category', $this->categoryRepository->findCategoriesByLocation(intval($this->settings['singleViewUid'])));
		}

		$image = $this->locationRepository->findByUid($location[0]['uid']) -> getImage();
		$location[0]['theImage'] =	$image;				


		// event dispatch
		$event = GeneralUtility::makeInstance('WSR\Mymap\Event\SingleViewEvent');
		$event->setLocation($location);
		$this->eventDispatcher = GeneralUtility::getContainer()->get(EventDispatcherInterface::class);		
		$this->eventDispatcher->dispatch($event);


		$this->view->assign('location', $location);
		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);
	}


	/**
	 * action randomView
	 * 
	 * @return void
	 */
	public function randomViewAction() {
		$locations = $this->locationRepository->findAll();
//		$locations = $this->locationRepository->findAllOverwrite();
		$counts = count($locations);
		$uid = rand(1, $counts);
		$location = $this->locationRepository->findByUid($uid);
		
/*
		// signal
		$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
		$ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeRandomRenderView', array(&$location, &$this));
*/
		$this->view->assign('location', $location);
		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);

/*
		in localconf of your extensionr add something like this

		$signalSlotDispatcher = 
		 \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');

		$signalSlotDispatcher->connect(  
			 'WSR\Mymap\Controller\LocationsController', 'beforeRandomRenderView', 'WSR\Yourext\Slots\RoomSlot', 'beforeRandomRenderView', FALSE  
		); 
 
		and in the slot class of your extension
		class RoomSlot extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
			public function beforeRandomRenderView(&$data, &$object) {     
				echo "Yes, beforeRandomRenderView was called";
				// here you can do your own stuff with $object
			}
		...
		}		
 */
		
	}



	/**
	 * action searchForm
	 * 
	 * @return void
	 */
	public function searchFormAction() {
		$this->_GP = $this->request->getArguments('tx_mymap_search');

	   	$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

	    $this->_GP = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST();
	    $this->view->assign('_GP', $this->_GP['tx_mymap_search']);

		$categories = $this->categoryRepository->findAllOverwrite($this->conf['storagePid']);
		for($i = 0; $i < count($categories); $i++) {
			$arr[$i]['uid']= $categories[$i]['uid'];	
			$arr[$i]['parent'] = $categories[$i]['parent'];	
			$arr[$i]['name'] = $categories[$i]['name'];	
		}	

	
		if (!count($arr)) {
			$this->addFlashMessage('No location categories found, please insert some first!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
		} else {
			$categories = $this->categoryRepository->buildTree($arr);
		}

		$this->view->assign('categories', $categories);
		
	}


	/**
	 * action autocompleterForm
	 * 
	 * @return void
	 */
	public function autocompleterFormAction() {
		$this->_GP = $this->request->getArguments('tx_mymap_search');

//\TYPO3\CMS\Core\Utility\DebugUtility::debug($_REQUEST);
		$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

	
		$this->_GP = \TYPO3\CMS\Core\Utility\GeneralUtility::_POST();
		$this->view->assign('_GP', $this->_GP['tx_mymap_search']);
		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);
		
	}

	/**
	 * action mapAll
	 * 
	 * @return void
	 */
	public function mapAllAction() {
		if (!$this->conf['storagePid']) {
			$this->flashMessage('Extension: mymap', 'No storage pid defined! Please define some in the constant
								editor for the plugin.',
								\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			return;
		}
		$this->updateLatLon();
		$locations = $this->locationRepository->findAllOverwrite($this->conf['storagePid']);
		for ($i = 0; $i < count($locations); $i++) {
			$category[$i] = $this->categoryRepository->findCategoriesByLocation($locations[$i]['uid']);
			// this is used by TYPO3 9.x instead of viewHelper for categories
			$locations[$i]['categories'] = $category[$i][0]['categories'];	

			if ($locations[$i]['image'] > 0) {
				$image = $this->locationRepository->findByUid($locations[$i]['uid']) -> getImage();
				$locations[$i]['theImage'] = $image;				
			}




		}
		
		for ($i = 0; $i < count($locations); $i++) {
			$categories[$i] = $category[$i][0]['categories'];
		}

		$this->view->assign('settings', $this->settings);

		$this->view->assign('categories', $categories);
		$this->view->assign('locations', $locations);
		

	}



	/**
	 * action search
	 * 
	 * @return void
	 */
	public function searchAction() {
		$this->updateLatLon();
		
		$this->_GP = $this->request->getArguments();
	
		// now get the startingpoint coordinates 
		$theAddress = array (
			'address' => $this->_GP['address'],
			'zipcode' => $this->_GP['zipcode'],
			'city' => $this->_GP['city'],
			'country' => $this->_GP['country'],
		);
		$latLon = $this->geocode($theAddress);

/*
$arguments = $this->request->getArguments();
$validatorResolver = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Validation\\ValidatorResolver');
$conjunctionValidator = $validatorResolver->createValidator('Conjunction');
$conjunctionValidator->addValidator($validatorResolver->createValidator('NotEmpty'));
$conjunctionValidator->addValidator($validatorResolver->createValidator('Boolean'));
$result = $conjunctionValidator->validate($arguments['agreelicenseterm']);
 
if ($result->hasErrors()) {
    // Benutzer wieder zurückschicken
    $this->addFlashMessage(LocalizationUtility::translate('must_agree_license_term',$this->extensionName), '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
    $this->forward("license");
}
*/


		if ($latLon->status == 'ZERO_RESULTS') {
			$this->flashMessage('Extension: mymap',
				\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('noStartingPointCoordinatesFound', 'mymap'),
				\TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
			$this->forward("searchForm", NULL, NULL, $this->request->getArguments());

			//forward  ($actionName, $controllerName = null, $extensionName = null, array  $arguments = null)  

		}

		if ($latLon->status != 'OK') {
			$this->flashMessage('Extension: mymap',
				$latLon->status,
				\TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
			$this->forward("searchForm", NULL, NULL, $this->request->getArguments());
		}




		if (!$this->conf['storagePid']) {
			$this->flashMessage('Extension: mymap', 'No storage pid defined! Please define some in the constant
								editor or in the tab behavior (Record Storage Page)	of the plugin.',
								\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			return;
		}


		// find all categories of all children
		// may be this can be commented
		$allCategories = $this->categoryRepository->findAllOverwrite($this->conf['storagePid']);
		
		// sanitizing categories						 
		if ($this->_GP['categories'] && preg_match('/^[0-9,]*$/', implode(',', $this->_GP['categories'])) != 1) {
			$this->flashMessage('Extension: mymap', \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('errorInCategories', 'mymap'), \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			$this->forward("searchForm", NULL, NULL, $this->request->getArguments());
		}						


		$cats = $this->_GP['categories'];
//		$cats = array();
//		if ($this->_GP['categories']) $cats = explode(',', $this->_GP['categories']);
		if (is_array($cats)) {
			for ($i = 0; $i < count($cats); $i++) {
				if ($i == 0)
				$children = $this->getChildren($allCategories, $cats[$i], $children);
				else
				$children = $this->getChildren($allCategories, $cats[$i], $children);
			}
		}
		if ($children) $this->_GP['categories'] = $children;



		$page = 0;
//		$locations = $this->locationRepository->findLocationsInRadius($latLon, $this->_GP['radius'], implode(',', $this->_GP['categories']),
		$locations = $this->locationRepository->findLocationsInRadius($latLon, $this->_GP['radius'], $this->_GP['categories'],
						$this->conf['storagePid'], $this->settings['resultLimit'], $page);


		for ($i = 0; $i < count($locations); $i++) {

			if ($locations[$i]['image'] > 0) {
				$image = $this->locationRepository->findByUid($locations[$i]['uid']) -> getImage();
				$locations[$i]['theImage'] = $image;				
			}


			if ($locations[$i]['images'] > 0) {
				$images = $this->locationRepository->findByUid($locations[$i]['uid']) -> getImages();
				$locations[$i]['theImages'] =	$images;				
			}
			if ($locations[$i]['files'] > 0) {
				$files = $this->locationRepository->findByUid($locations[$i]['uid'])->getFiles();
				$locations[$i]['theFiles'] = $files;				
			}
		}


/*						
			for ($i = 0; $i < count($locations); $i++) {
				$category[$i] = $this->categoryRepository->findCategoriesByLocation($locations[$i]['uid']);
			}
				
			for ($i = 0; $i < count($locations); $i++) {
				$categories[$i] = $category[$i][0]['categories'];
			}

			$this->view->assign('categories', $categories);
*/
						
		if (count($locations) == 0) {
			$this->flashMessage('Extension: mymap', \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('noLocationsFound', 'mymap'), \TYPO3\CMS\Core\Messaging\AbstractMessage::INFO);
			$this->forward("searchForm", NULL, NULL, $this->request->getArguments());
		}

		for ($i = 0; $i < count($locations); $i++) {
			$category[$i] = $this->categoryRepository->findCategoriesByLocation($locations[$i]['uid']);
		}
		
		for ($i = 0; $i < count($locations); $i++) {
			$categories[$i] = $category[$i][0]['categories'];
		}

/*
		// signal
		$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
		$ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeSearchRenderView', array(&$locations, &$this));
*/		
		// event dispatch
		$event = GeneralUtility::makeInstance('WSR\Mymap\Event\SearchViewEvent');
		$event->setLocations($locations);
		$this->eventDispatcher = GeneralUtility::getContainer()->get(EventDispatcherInterface::class);		
		$this->eventDispatcher->dispatch($event);
		$locations = $event->getLocations();
		
//Krexx($locations);


		$this->view->assign('settings', $this->settings);
		
		$this->view->assign('startingPoint', $latLon);
		$this->view->assign('categories', $categories);
		$this->view->assign('locations', $locations);

		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);
		
		
        $this->view->assign('_GP', $this->_GP);
//        if ( ($this->_GP['city'] || $this->_GP['zipcode'] ) || ($this->_GP['lat'] && $this->_GP['lon'] )) // from autocompleter ($this->_GP['lat'] && $this->_GP['lon'] )
        if ( ($this->_GP['city'] || $this->_GP['zipcode'] ) || ($this->_GP['autocompleter'] )) // from autocompleter ($this->_GP['autocomplter'])
            $this->view->assign('showMap', 1);
	}




	function getChildren($arr, $id, $children) {
		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i]['parent'] == $id) {
//				$children .= ',' . $arr[$i]['uid'];
				$children = $this->getChildren($arr, $arr[$i]['uid'], $children);
			}
		}
		
		return $id . ',' . $children;
//		return $children;
	}






	/**
	 * action ajaxSearch
	 * 
	 * @return void
	 */
	public function ajaxSearchAction() {


		
		if (!$this->conf['storagePid']) {
			$this->flashMessage('Extension: mymap', 'No storage pid defined! Please define some in the constant
								editor for the plugin.',
								\TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			return;
		}



		/* for findAll set the storagePid correct
		$users = $this->feUserRepository->findAll();		
		$this->view->assign('users', $users);
		*/
		
		$this->updateLatLon();
		$this->view->assign('id', $GLOBALS['TSFE']->id);
		$categories = $this->categoryRepository->findAll();


		$categories = $this->categoryRepository->findAllOverwrite($this->conf['storagePid']);

	/* used for number of locations shown after category name like Internet(8)
	*/

		for ($i =0; $i < count($categories); $i++) {
			$categoriesCount[$i] = $this->locationRepository->findCountsByCategory($categories[$i]['uid']);
		}


	
		$this->view->assign('categoriesCount', $categoriesCount ?? 0);



		for($i = 0; $i < count($categories); $i++) {
			$arr[$i]['uid']= $categories[$i]['uid'];	
			$arr[$i]['parent'] = $categories[$i]['parent'];	
			$arr[$i]['name'] = $categories[$i]['name'];	
			$arr[$i]['counts'] = $categoriesCount[$i];	
		}	


		$categories = $this->categoryRepository->buildTree($arr);

		$locations = $this->locationRepository->findAll();
		
		$this->view->assign('settings', $this->settings);

		$this->view->assign('locationsCount', count($locations));
		$this->view->assign('categories', $categories);

		$context = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Context\Context::class);
		$sys_language_uid = $context->getPropertyFromAspect('language', 'id'); 
		$this->view->assign('Lvar', $sys_language_uid);
	}


	
	/**
	 * action route
	 * 
	 * @return void
	 */
	public function routeAction() {
		$this->_GP = $this->request->getArguments();
		$startingPoint = array (
			'lat' => $this->_GP['startingPointLat'],
			'lon' => $this->_GP['startingPointLon'],
			
		);

		$destination = array (
			'lat' => $this->_GP['destinationLat'],
			'lon' => $this->_GP['destinationLon'],
			
		);

/*
		// signal
//		$signalSlotDispatcher = \t3lib_div::makeInstance('Tx_Extbase_SignalSlot_Dispatcher');
		$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
		$ret =$signalSlotDispatcher->dispatch(__CLASS__, 'beforeRouteRenderView', array(&$this->_GP, &$this));
*/

		$this->view->assign('destination', $destination);

		$start = array (
			'address' => $this->_GP['startAddress'],
			'zipcode' => $this->_GP['startZipcode'],
			'city' => $this->_GP['startCity'],
		);
		$this->view->assign('startingAddress', $start);


		$this->view->assign('startingPoint', $startingPoint);
		$target = array (
			'address' => $this->_GP['targetAddress'],
			'zipcode' => $this->_GP['targetZipcode'],
			'city' => $this->_GP['targetCity'],
		);
		$this->view->assign('target', $target);
		$this->view->assign('Lvar', $GLOBALS['TSFE']->config['config']['sys_language_uid']);
		
	}





	protected function updateLatLon() {
		$locations = $this->locationRepository->updateLatLon($this->conf['storagePid']);

		foreach ($locations as $location) {
			$theAddress = array (
				'address' => $location['address'],		
				'zipcode' => $location['zipcode'],		
				'city' => $location['city'],		
				'country' => $location['country']		
			);
			sleep(rand(1, 3)); // makes Google happy

			$latLon = $this->geocode($theAddress);
			if ($latLon->status == 'OK') {
				$this->locationRepository->setLatLon($location['uid'], $latLon->lat, $latLon->lon);
			}
			else {
				$this->flashMessage('Mymap geocoder', 'could not geocode ' . $location['name']. ' ' . $theAddress['address'] . ' ' . $latLon->status);
			}
				
		}
	}

		
	public function geocode($theAddress) {
		//for urlencoding
		$vars = array (
			'zipcode',
			'city',
			'address',
			'country'
		);

/*		
		while (list (, $v) = each($vars)) {
			$theAddress[$v] = urlencode($theAddress[$v]);
		}
*/
		foreach ($vars as $k => $v) {
			$theAddress[$v] = urlencode($theAddress[$v]);
		}
		
		

		$address = $theAddress['address'];
		$city = $theAddress['city'];
		$country = $theAddress['country'];
		$zipcode = $theAddress['zipcode'];


		######################################Main Geocoders#####################################
		if (!$lat_lon->lat && !$lat_lon->lon) {

			// for geocoding we need a server API key not a browser key
			if ($this->settings['googleServerApiKey']) {
				$key = '&key=' . $this->settings['googleServerApiKey'];
			}				

			$apiURL = "https://maps.googleapis.com/maps/api/geocode/json?address=$address,+$zipcode+$city,+$country&sensor=false" . $key;
			$addressData = $this->get_webpage($apiURL);

//krexx($apiURL);
//krexx($addressData);

			$coordinates[1] = json_decode($addressData)->results[0]->geometry->location->lat;
			$coordinates[0] = json_decode($addressData)->results[0]->geometry->location->lng;

			$latLon = new \stdClass();
			$latLon->lat = $coordinates[1];
			$latLon->lon = $coordinates[0];
			$latLon->status = json_decode($addressData)->status;

		}

		return $latLon;
	}

	function get_webpage($url) {
		//global $db;
		if (ini_get('allow_url_fopen'))
			$this->conf['useCurl'] = 0;
		else
			$this->conf['useCurl'] = 1;

		if ($this->conf['useCurl']) {
			$sessions = curl_init();
			curl_setopt($sessions, CURLOPT_URL, $url);
			curl_setopt($sessions, CURLOPT_HEADER, 0);
			curl_setopt($sessions, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($sessions);
			curl_close($sessions);
		} else {
//			$data = t3lib_div::getUrl($url);
			$data = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL($url); 
		}
		return $data;
	}
	
	/**
	 * Flash a message
	 *
	 * @param string title 
	 * @param string message
	 * 
	 * @return void
	 */
	private function flashMessage($title, $message, $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING) {
		$this->addFlashMessage(
			$message,
			$title,
			$severity,
			$storeInSession = TRUE
		);
	}	
	
}