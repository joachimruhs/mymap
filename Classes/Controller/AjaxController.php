<?php

namespace WSR\Mymap\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\Response;

use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\TypoScript\TemplateService;
use TYPO3\CMS\Core\Utility\RootlineUtility;

/***
 *
 * This file is part of the "Mymap" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 - 2023 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
 *
 ***/

/**
 *
 *
 * @package mymap
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * 
 */
class AjaxController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * locationRepository
	 *
	 * @var \WSR\Mymap\Domain\Repository\LocationRepository
	 */
	protected $locationRepository;

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





	/**
	 * action ajaxPage
	 * @return \string JSON
	 */
	public function ajaxPageAction() {
		// not used yet 
		$requestArguments = $this->request1->getArguments();
		return json_encode($requestArguments);
	}
	
	/**
	 * action ajaxEidGeocode
	 * @return \stdclass $latLon
	 */
	public function ajaxEidGeocodeAction() {
		$requestArguments = $this->request1->getParsedBody()['tx_mymap_ajax'];

		$address = urlencode($requestArguments['address']);
		$country = urlencode($requestArguments['country']);
		
		if ($this->settings['googleServerApiKey']) {
			$key = '&key=' . $this->settings['googleServerApiKey'];
		}				

		$apiURL = "https://maps.googleapis.com/maps/api/geocode/json?address=$address,+$country&sensor=false" . $key;
		$addressData = $this->get_webpage($apiURL);

        $latLon = new \stdClass();
		$latLon->status = json_decode($addressData)->status;
        if ($latLon->status == 'OK') {
            $coordinates[1] = json_decode($addressData)->results[0]->geometry->location->lat;
            $coordinates[0] = json_decode($addressData)->results[0]->geometry->location->lng;
    
            $latLon->lat = (float) $coordinates[1];
            $latLon->lon = (float) $coordinates[0];
        }
		$latLon->status = json_decode($addressData)->status;

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
	 * @param TYPO3\CMS\Core\Http\ServerRequestInterface $request
	 * @param TYPO3\CMS\Core\Http\Response      $response
	 */
	public function indexAction(ServerRequestInterface $request, Response $response)
	{
		switch ($request->getMethod()) {
			case 'GET':
				$response = $this->processGetRequest($request, $response);
				break;
			case 'POST':
				$response = $this->processPostRequest($request, $response);
				break;
			default:
				$response->withStatus(405, 'Method not allowed');
		}
	
		return $response;
	}



	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface      $response
	 */
	protected function processGetRequest(ServerRequestInterface $request, Response $response) {
		$view = $this->getView();
	
		$response->withHeader('Content-type', ['text/html; charset=UTF-8']);
		$response->getBody()->write($view->render());
        return $response;
	}

	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param TYPO3\CMS\Core\Http\Response      $response
	 */
	protected function processPostRequest(ServerRequestInterface $request, Response $response)
	{
		$queryParams = $request->getQueryParams();
	
	//	$queryParameters = $request->getParsedBody();
	//	$pid = (int)$queryParameters['pid'];
	//	$queryParams = $queryParameters;
		$frontend = $GLOBALS['TSFE'];
	
		/** @var TypoScriptService $typoScriptService */
/*
		$typoScriptService = GeneralUtility::makeInstance('TYPO3\CMS\Core\TypoScript\TypoScriptService');
		$this->configuration = $typoScriptService->convertTypoScriptArrayToPlainArray($frontend->tmpl->setup['plugin.']['tx_mymap.']);

		$this->settings = $this->configuration['settings'];
		$this->conf['storagePid'] = $this->configuration['persistence']['storagePid'];
*/
        $fullTypoScript = $request->getAttribute('frontend.typoscript')->getSetupArray()['plugin.']['tx_mymap.'] ;
	    $this->configuration = $request->getAttribute('frontend.typoscript')->getSetupArray()['plugin.']['tx_mymap.'];

		$this->settings = $this->configuration['settings.'];
		$this->conf['storagePid'] = $this->configuration['persistence.']['storagePid'];
        
        
        
		$this->request1 = $request;
		$out = $this->ajaxEidAction();
		return $out;	

//		echo $out;
	
		//    $response->getBody()->write(json_encode($queryParams));
		//    $response->getBody()->write($out);
		
		/** @var Response $response */
		//		$response = GeneralUtility::makeInstance(Response::class);
		//		$response->getBody()->write($out);
		
/*		
		return $response;
	
		
		
		
		$view = $this->getView();
		$hasErrors = false;
		// ... some logic
	
		if ($hasErrors) {
			$response->withHeader('Content-type', ['text/html; charset=UTF-8']);
			$response->getBody()->write($view->render());
		} else {
			$response->withHeader('Content-type', ['application/json; charset=UTF-8']);
			$response->getBody()->write(json_encode(['success' => true]));
		}
*/

	}


	/**
	 * @return \TYPO3\CMS\Fluid\View\StandaloneView
	 */
	protected function getView() {
//		$templateService = GeneralUtility::makeInstance(TemplateService::class);
		// get the rootline
	//    $rootLine = $pageRepository->getRootLine($pageRepository->getDomainStartPage(GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY')));
		$rootlineUtility = GeneralUtility::makeInstance(RootlineUtility::class, 0);
	
		$rootLine = $rootlineUtility->get();
	
		// initialize template service and generate typoscript configuration
		$templateService->runThroughTemplates($rootLine);
		$templateService->generateConfig();
	
        $fluidView = GeneralUtility::makeInstance(StandaloneView::class);
        $fluidView->setLayoutRootPaths($templateService->setup['plugin.']['tx_yourext.']['view.']['layoutRootPaths.']);
		$fluidView->setTemplateRootPaths($templateService->setup['plugin.']['tx_yourext.']['view.']['templateRootPaths.']);
		$fluidView->setPartialRootPaths($templateService->setup['plugin.']['tx_yourext.']['view.']['partialRootPaths.']);
		$fluidView->getRequest()->setControllerExtensionName('YourExt');
		$fluidView->setTemplate('index');
	
		return $fluidView;
	}


	/**
	 * action ajaxEid
	 * @return \string html
	 */
	public function ajaxEidAction() {
        $out = '';
/*
      	$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$this->configuration = $configuration;
		$this->conf['storagePid'] = $configuration['persistence']['storagePid'];
*/
		
        $requestArguments = $this->request1->getParsedBody()['tx_mymap_ajax'];

		if ($requestArguments['categories'] = $requestArguments['categories'] ?? [])
		$this->_GP['categories'] = @implode(',', $requestArguments['categories']);
		// sanitizing categories
        $this->_GP['categories'] = $this->_GP['categories'] ?? '';
		if ($this->_GP['categories'] && preg_match('/^[0-9,]*$/', $this->_GP['categories']) != 1) {
			$this->_GP['categories'] = '';
		}		
		
		
		
		
// NEW
		// to minimize Google Server API requests
		// only geocode if no coordinates are given
		if ($requestArguments['lat'] == '' || $requestArguments['lon'] == '') {
			$latLon = $this->ajaxEidGeocodeAction();
		} else {
			$latLon = new \stdClass();
			$latLon->status = 'OK';
			$latLon->lat = (float) $requestArguments['lat'];
			$latLon->lon = (float) $requestArguments['lon'];
			
			if ($latLon->lat == 0 || $latLon->lon == 0)
				$latLon = $this->ajaxEidGeocodeAction();
		}
		if ($latLon->status != 'OK') {
			$out = '<div class="ajaxMessage">Geocoding Error: ' . $latLon->status . '</div>';
			$out .= '<script	type="text/javascript">
			$(".ajaxMessage").fadeIn(2000);
			</script>';
			return $out;
		} else {
			$out .= '<script	type="text/javascript">
				$("#tx_mymap_lat").val(' . $latLon->lat . ');
				$("#tx_mymap_lon").val(' . $latLon->lon . ');
			</script>';
		}
		

		$this->_GP['radius'] = (float) $requestArguments['radius'];


		$limit = $this->settings['resultLimit'];

$page = $requestArguments['page'];


if ($requestArguments['page'] == -1) {
	$limit = 1000;
	$page = 0;
}



		// find all categories of all children
		// may be this can be commented
		$allCategories = $this->categoryRepository->findAllOverwrite($this->conf['storagePid']);
		
		$cats = array();
        $children = '';
		if ($this->_GP['categories']) $cats = explode(',', $this->_GP['categories']);
		for ($i = 0; $i < count($cats); $i++) {
			if ($i == 0)
			$children = $this->getChildren($allCategories, $cats[$i], $children);
			else
			$children = $this->getChildren($allCategories, $cats[$i], $children);
		}
		
		if ($children) $this->_GP['categories'] = $children;

		$locations = $this->locationRepository->findLocationsInRadius($latLon, $this->_GP['radius'], $this->_GP['categories'], $this->conf['storagePid'], $limit, $page);

		$allLocations = $this->locationRepository->findAllByCategory($latLon, $this->_GP['radius'], $this->_GP['categories'], $this->conf['storagePid'], $limit, $page);

		// field image, images and files
		for ($i = 0; $i < count($locations); $i++) {
			if ($locations[$i]['image'] > 0) {
				$image = $this->locationRepository->findByUid($locations[$i]['uid']) -> getImage();
				$locations[$i]['theImage'] =	$image;				
			}
			if ($locations[$i]['media'] > 0) {
				$media = $this->locationRepository->findByUid($locations[$i]['uid']) -> getMedia();
				$locations[$i]['theMedia'] =	$media;				
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




		if (count($locations) == 0) {
			$out = '<div class="ajaxMessage">' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('noLocationsFound', 'mymap') .'</div>';
			$out .= '<script	type="text/javascript">';
			// remove marker from map
			$out .= 'for (var i = 0; i < marker.length; i++) {
				marker[i].setMap(null);
			}
			$(".ajaxMessage").fadeIn(2000);
			</script>';
			return $out;
		}
			
		$out .= $this->getMarkerJS($locations, $categories ?? '', $latLon, $this->_GP['radius']);
		// get  the loctions list
		
		if ($requestArguments['page'] != -1)  // do not show the list for page loading 
			$out .= $this->getLocationsList($locations, $categories ?? '', $allLocations);
		
		return $out;
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




	protected function getMarkerJS($locations, $categories, $latLon, $radius) {
		if ($this->settings['enableMarkerAnimation']) 
			$animation = 'animation: google.maps.Animation.DROP,';
		else $animation = '';

		$out = '<script	type="text/javascript">';


		// remove marker from map
		$out .= 'for (i = 0; i < marker.length; i++) {
			marker[i].setMap(null);
		}
		marker = [];
		';

		$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);

		for ($i = 0; $i < count($locations); $i++) {


			$lat = $locations[$i]['lat'];
			$lon = $locations[$i]['lon'];
			
			if (!$lat) continue;

			$fileObjects = $fileRepository->findByRelation('tx_mymap_domain_model_location', 'icon', $locations[$i]['uid']);
			$locationIcon = '';
			if ($fileObjects) {
				$locationIcon = $fileObjects[0]->getOriginalFile()->getPublicUrl();
			}
			
			$imageObjects = '';
			$imageObjects = $fileRepository->findByRelation('tx_mymap_domain_model_location', 'image', $locations[$i]['uid']);

            $locationImage = '';
            if ($imageObjects) {
				$locationImage = $imageObjects[0]->getOriginalFile()->getPublicUrl();
			}

			$out .= 'var myLatLng = new google.maps.LatLng(' . $lat . ', ' . $lon .');';

			if ($locationIcon) {
			$out .= 'marker[' . $i . '] = new google.maps.Marker({
									position: myLatLng,
									map: map,
									title: "' . $locations[$i]['name'] .'",
									' . $animation . '
//									animation: google.maps.Animation.DROP,
									icon: "/' . $locationIcon .'"
									});
									mapBounds.extend(myLatLng);

									';
			
			
			} else {

			$out .= 'marker[' . $i . '] = new google.maps.Marker({
									position: myLatLng,
									map: map,
									title: "' . $locations[$i]['name'] .'",
									' . $animation . '
//									animation: google.maps.Animation.DROP,
									icon: "/typo3conf/ext/mymap/Resources/Public/Icons/pointerBlue.png"
									});
									mapBounds.extend(myLatLng);

									';
			}
		
			// infoWindows
			$out .= $this->renderFluidTemplate('AjaxLocationListInfoWindow.html', array('location' => $locations[$i], 'categories' => $categories, 'i' => $i,
																						'locationImage' => $locationImage, 'startingPoint' => $latLon, 'settings' => $this->settings));

			
		} // for

		if ($this->settings['enableSearchCircle']) {		
		$out .= '
			function drawCircle(radius, lat, lng) {
				radius *= 1000;
				var center = new google.maps.LatLng(lat, lng);
				circle = new google.maps.Circle({
					center: center,
					radius: radius,
					strokeColor: "#FF0000",
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: "#FF0000",
					fillOpacity: 0,
					//editable: true,
					map: map
				});
			}
			drawCircle(' . $radius . ', ' . $latLon->lat . ',' . $latLon->lon . ');

		';

		}

		$out .= 'map.fitBounds(mapBounds);';		

		
		
		
		return $out . '</script>';
	}
	
	function getLocationsList($locations, $categories, $allLocations) {
		$out = $this->renderFluidTemplate('AjaxLocationList.html', array('locations' => $locations, 'categories' => $categories,
										  'settings' => $this->settings, 'locationsCount' => count($allLocations)));
		return $out;
	}
	
	
	/**
	 * Renders the fluid template
	 * @param string $template
	 * @param array $assign
	 * @return string
	 */
	public function renderFluidTemplate($template, Array $assign = array()) {
		$templateRootPath = $this->configuration['view.']['templateRootPaths.'][1];
		
		
		$templatePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($templateRootPath . 'Location/' . $template);
		$view = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
		$view->setTemplatePathAndFilename($templatePath);
		$view->assignMultiple($assign);


        $view->setRequest($this->request1);
		return $view->render();
	}

	
}

?>
