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

use \TYPO3\CMS\Core\Core\Environment;


class MapJSViewHelper extends AbstractViewHelper {

	/**
	* Arguments Initialization
	*/
	public function initializeArguments() {
		$this->registerArgument('locations', 'mixed', 'The locations for the map', TRUE);
		$this->registerArgument('city', 'string', 'The city for the map', TRUE);
		$this->registerArgument('settings', 'mixed', 'The settings', TRUE);
	}


    /**
    * Returns the map javascript
    * 
    * @param array $arguments 
    * @param \Closure $renderChildrenClosure
    * @param RenderingContextInterface $renderingContext
    * @return string
    */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
		$locations = $arguments['locations'];
		$city = $arguments['city'];

		if ($arguments['settings']['enableMarkerAnimation']) 
			$animation = 'animation: google.maps.Animation.DROP,';
		else $animation = '';

		$out = self::getMapJavascript($locations, $arguments['settings']);
		
		$fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);

		$out .= '<script type="text/javascript">
            function getMarkers() {';

			if (is_array($locations)) {
				for ($i = 0; $i < count($locations); $i++) {
					$lat = $locations[$i]['lat'];
					$lon = $locations[$i]['lon'];
					
					$out .= 'var myLatLng = new google.maps.LatLng(' . $lat. ',' . $lon .');';

					$fileObjects = $fileRepository->findByRelation('tx_mymap_domain_model_location', 'icon', $locations[$i]['uid']);
					$locationIcon = '';
					if ($fileObjects) {
						$locationIcon = GeneralUtility::getIndpEnv('TYPO3_REQUEST_HOST') . '/' . $fileObjects[0]->getOriginalFile()->getPublicUrl();
					}
					
					if ($locationIcon) {
						$out .= 'marker[' . $i . '] = new google.maps.Marker({
											position: myLatLng,
											map: map,
											title: "' . $locations[$i]['name'] .'",
											icon: "' . $locationIcon .'",
											' . $animation . '
											map: map
											});
											mapBounds.extend(myLatLng);
		
											';
					
					
					} else {
		
						$out .= 'marker[' . $i . '] = new google.maps.Marker({
											position: myLatLng,
											title: "' . $locations[$i]['name'] .'",
											icon: "/typo3conf/ext/mymap/Resources/Public/Icons/pointerBlue.png",
										' . $animation . '
											map: map
											});
											mapBounds.extend(myLatLng);
		
											';
					}
		
		
				}
			}
            $out .= '}</script>';
		return $out;
	 }
	 
	 public static function getMapJavascript($locations, $settings) {
        $out = '<script type="text/javascript">
        var myOptions;
        var marker = [];
        var infoWindow = [];
        var map;
        var mapBounds = new google.maps.LatLngBounds();
        var circle = null;
        
        function load(){
        
            var lon;
            var lat;
        
            var zoom1 = 17 - 8;
        
            var latlng = new google.maps.LatLng(' . $settings['initialMapCoordinates'] . ');
        
             myOptions = {
              zoom: zoom1,
              center: latlng,
        //		      mapTypeId: google.maps.MapTypeId.ROADMAP,
              scaleControl: true,
			  gestureHandling: "cooperative",
              zoomControl: true,
              zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP
                },
        
//              panControl: true,
			  draggable: 1,			  
              rotateControl: true,
//              rotateControlOptions: {
//                                position: google.maps.ControlPosition.LEFT_TOP
//                            },
              disableDoubleClickZoom: 1,

                ';
        
            if ($settings['enableStreetViewLayer']) {                
                $out .= '  streetViewControl: 1,
                            streetViewControlOptions: {
                                position: google.maps.ControlPosition.LEFT_TOP
                            },
                        ';
            }
        
            $out .= '
            };
        
            map = new google.maps.Map(document.getElementById("map"), myOptions);
            if (mapBounds.length > 0)
        			map.fitBounds(mapBounds);

			// 45 degree images of cities		
			map.setTilt(45);
					
            ';
            
            if ($settings['enableBicyclingLayer']) {                
                $out .= '
                var bikeLayer = new google.maps.BicyclingLayer();
                bikeLayer.setMap(map);
                ';
            }
      
            if ($settings['enableTrafficLayer']) {                
                $out .= '
                var trafficLayer = new google.maps.TrafficLayer();
                trafficLayer.setMap(map);
                ';
            }

            $out .= '

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
//				   map.setCenter(event.latLng);
			   });
		

				} // load
				
/*
				var circle = null;
				function drawCircle(radius, lat, lon) {
					var center = new google.maps.LatLng(lat, lon);
					circle = new google.maps.Circle({
						center: center,
						radius: radius * 1000,
						strokeColor: "#FF0000",
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: "#FF0000",
						fillOpacity: 0,
			//			editable: true,
						map: map
					});
		
				}
*/				
				
				
				
        </script>';
        return $out;
	 }
	 
	 
}

?>
