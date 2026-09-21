<?php
namespace WSR\Mymap\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/***
 *
 * This file is part of the "Myttaddressmap" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 - 2026 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
 *
 ***/


class MapAjaxJSViewHelper extends AbstractViewHelper {
	/**
	* Arguments Initialization
	*/
	public function initializeArguments(): void {
		$this->registerArgument('locations', 'array', 'The locations for the map', TRUE);
		$this->registerArgument('city', 'string', 'The city for the map', TRUE);
		$this->registerArgument('settings', 'mixed', 'The settings', TRUE);
	}

    /**
    * Returns the map javascript
    * 
    * @return string
    */
    public function render(): string
    {
		$locations = $this->arguments['locations'] ?? '';
		$city = $this->arguments['city'] ?? '';
		$settings = $this->arguments['settings'];

		$animation = '';
		
		$out = self::getMapJavascript($locations, $settings);

		// no more code needed 

		return $out;
	}

	 
    public function getMapJavascript($locations, $settings) {
        $out = '';
        if ($settings['enableMarkerClusterer']) {
            $out .= '<script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>';
		}
	 
	 $out .= '<script type="text/javascript">
        var myOptions;
        var marker = [];
        var infoWindow = [];
        var map;
        var mapBounds = new google.maps.LatLngBounds();
        var circle = null;
        
        function load(){
        
            var lon;
            var lat;
        
            var zoom1 = 9;
        
            var latlng = new google.maps.LatLng(' . $settings['initialMapCoordinates'] . ');
        
             myOptions = {
              mapId: "' . ($settings['mapId'] ?? null ?: 'DEMO_MAP_ID') . '",
              zoom: zoom1,
              center: latlng,
        //		      mapTypeId: google.maps.MapTypeId.ROADMAP,
              scaleControl: true,
			  gestureHandling: "cooperative",
			  zoomControl: true,
              zoomControlOptions: {
                    position: google.maps.ControlPosition.LEFT_TOP
                },
        
              panControl: true,
			  draggable: 1,			  
              rotateControl: true,
//              rotateControlOptions: {
//                                position: google.maps.ControlPosition.LEFT_TOP
//                            },
              disableDoubleClickZoom: 1,
			  ';

            if ($settings['enableStreetViewLayer'] ?? '') {                
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
				  marker = new google.maps.marker.AdvancedMarkerElement({
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
				
//					getMarkers();
		
				// panning for mobile devices
				google.maps.event.addListener(map, "click",function(event) {
				   //map.setZoom(9);
//				   map.setCenter(event.latLng);
			   });
			';

// ********************************************************************
// markerClusterer did not work in Ajax mode!
//markerClusterer = new markerClusterer.MarkerClusterer({map, marker});

//            if ($settings['enableMarkerClusterer']) {                
//			}


		$out .= '

			} // load
        </script>';
				
		return $out;
	 }
	 

	 
}

?>