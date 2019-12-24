<?php
namespace WSR\Mymap\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;


/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018-2019 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

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
		$fileObjects = $fileRepository->findByRelation('tx_mymap_domain_model_location', 'icon', $location->getUid());
		if ($fileObjects) {
			$locationIcon = $fileObjects[0]->getOriginalFile()->getPublicUrl();
		}

		
		$out = self::getMapJavascript($location);
		$out .= '<script type="text/javascript">function getMarkers() {';
			$lat = $location->getLat();
			$lon = $location->getLon();
			
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
					                title: "' . $location->getName() .'",
					                icon: "/' . $locationIcon .'"
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

		    var latlng = new google.maps.LatLng(' . $location->getLat() . ',' . $location->getLon() . ');
		     myOptions = {
		      zoom: zoom1,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP,
		      scaleControl: 1,
			  zoomControl: 1,

		//	  panControl: false,
		      disableDoubleClickZoom: 1,
			  scrollwheel: true,
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