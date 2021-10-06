<?php
namespace WSR\Mymap\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;


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

class MapShowJSViewHelper extends AbstractViewHelper {
	/**
	* Arguments Initialization
	*/
	public function initializeArguments() {
		$this->registerArgument('location', 'mixed', 'The location for the map', TRUE);
		$this->registerArgument('city', 'string', 'The city for the map', TRUE);
	}


     /**
	 * Returns the map javascript
	 *
	 * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
	 * @return string
	 */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
		$location = $arguments['location'];
		$city = $arguments['city'];

		$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
		$fileObjects = $fileRepository->findByRelation('tx_mymap_domain_model_location', 'icon', $location[0]['uid']);
		if ($fileObjects) {
			$locationIcon = $fileObjects[0]->getOriginalFile()->getPublicUrl();
		}

		
		$out = self::getMapJavascript($location);
		$out .= '<script type="text/javascript">function getMarkers() {';
			$lat = $location[0]['lat'];
			$lon = $location[0]['lon'];
			
			$out .= 'var myLatLng = new google.maps.LatLng(' . $lat. ',' . $lon .');';
			$out .= 'var shadow = new google.maps.MarkerImage("typo3conf/ext/mymap/Resources/Public/Icons/shadow.png",
					                // The shadow image is larger in the horizontal dimension
					                // while the position and offset are the same as for the main image.
					                new google.maps.Size(37, 37),
					                new google.maps.Point(0,0),
					                new google.maps.Point(10, 37));';


			if ($locationIcon) {
 			$out .= 'marker[0] = new google.maps.Marker({
					                position: myLatLng,
					                map: map,
					                title: "' . $location[0]['name'] .'",
					                icon: "' . $locationIcon .'"
					                });
									//mapBounds.extend(myLatLng);

									';
			
			
			} else {

 			$out .= 'marker[0] = new google.maps.Marker({
					                position: myLatLng,
					                map: map,
					                title: "' . $locations[$i]['name'] .'",
					                icon: "/typo3conf/ext/mymap/Resources/Public/Icons/pointerBlue.png",
					                shadow: shadow
					                });
									//mapBounds.extend(myLatLng);

//map.setCenter(myLatLng);
//map.setZoom(5);


									';
			}



		$out .= '}</script>';
		return $out;
	 }
	 
	 public static function getMapJavascript($location) {
		$out = '<script type="text/javascript">
		var myOptions;
		var marker = [];
		var infoWindow = [];
		var map;
        var mapBounds = new google.maps.LatLngBounds();

		function load(){
			var circle = null;
		    var circleRadius = 1.5; // Miles

			var lon;
			var lat;

			var zoom1 = 16;

		    var latlng = new google.maps.LatLng(' . $location[0]['lat'] . ',' . $location[0]['lon'] . ');
		     myOptions = {
		      zoom: zoom1,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP,
		      scaleControl: 1,
			  zoomControl: 1,
			  gestureHandling: "cooperative",

		//	  panControl: false,
		      disableDoubleClickZoom: 1,
//			  scrollwheel: true,
		 	  streetViewControl: 1
		    };
		    map = new google.maps.Map(document.getElementById("map"), myOptions);
//			map.fitBounds(mapBounds);


		function addMarker(location) {
		  marker = new google.maps.Marker({
		    position: location,
		    map: map
		  });
		  markersArray.push(marker);
		}

		function removeMarker(marker) {
			if(marker.setMap != null) marker.setMap(null);
		}

		function showMarker(marker) {
		     marker.setMap(map);
		}

			getMarkers();

		// panning for mobile devices
		google.maps.event.addListener(map, "click",function(event) {
		   //map.setZoom(9);
		   map.setCenter(event.latLng);
	   });
			
		} // load
		</script>';
		return $out;
	 }
	 
	 
}

?>