<?php
namespace WSR\Mymap\ViewHelpers;

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

class RouteJSViewHelper extends AbstractViewHelper {
	/**
	* Arguments Initialization
	*/
	public function initializeArguments() {
		$this->registerArgument('startingPoint', 'array', 'The starting point', TRUE);
		$this->registerArgument('destination', 'array', 'The destination', TRUE);
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
		$out = self::getMapJavascript($arguments['startingPoint'], $arguments['destination']);
		$out .= '<script type="text/javascript">function getMarkers() {';
		$out .= '}</script>';
		return $out;
	 }
	 
	 public static function getMapJavascript($startingPoint, $destination) {
		$out .= '<script type="text/javascript">


var map;
var layers = [];
var layerControl;
var markersArray = [];



  var map, map0, map1;
  var directionDisplay;
  var directionsService;
  var stepDisplay;
  var markers = [];
  var infoWindows = [];
  var myRoute;

function load(){

    directionsService = new google.maps.DirectionsService();
    var center = new google.maps.LatLng(48,8);
    var myOptions = {
      zoom: 17 - 8,
      mapTypeId: google.maps.MapTypeId.ROADMAP,
//  	  streetViewControl: $enableStreetViewOverlay,
      center: center,
      scaleControl: 1
    }

    map = new google.maps.Map(document.getElementById("map"), myOptions);
// 	map.enableKeyDragZoom();


	google.maps.event.addListener(map, "click", function() {
	  	//infoWindows[0].close(map, markers[0]);
	  	//infoWindows[1].close(map, markers[1]);
	});


    // Create a renderer for directions and bind it to the map.
	var multiRoute = 0


	if (!multiRoute) {
    	var rendererOptions = {
			suppressMarkers: true,
			draggable: true,
//			panel: document.getElementById("routePanel"),
			map: map
	    }
    }
    else {
    	var rendererOptions = {
			suppressMarkers: false,
			map: map
    	}
	}
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions)
    stepDisplay = new google.maps.InfoWindow();

    markersArray = [];

    // Retrieve the start and end locations and create
    // a DirectionsRequest using WALKING directions.
	if (!multiRoute) {

    var request = {
        origin: "' . $startingPoint['lat'] . ',' . $startingPoint['lon'] . '",
        destination: "' . $destination['lat'] . ',' . $destination['lon'] . '",
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    // Route the directions and pass the response to a
    // function to create markers for each step.
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        //var warnings = document.getElementById("routePanel");
	    //warnings.innerHTML = "<b>1111111" + response.routes[0].warnings + "</b>";
        directionsDisplay.setDirections(response);
        directionsDisplay.setPanel(document.getElementById("routePanel"));
        showSteps(response);

      }
      else {
        var warnings = document.getElementById("routePanel");
	    warnings.innerHTML = "<b>xxxxxxx" + response.routes[0].warnings + "</b>";
      }
    });

	}
	else { // multiRoute
	   var wayPoints = [];
	   $wayPoints
		var request = {
	        origin: "$start",
			destination: "$start",
	        waypoints: wayPoints,
	      	region: "de",
	        travelMode: google.maps.DirectionsTravelMode.DRIVING
	    };


    directionsService.route(request, function(response, status) {
//alert(status);
      if (status == google.maps.DirectionsStatus.OK) {
        //var warnings = document.getElementById("warningPanel");
	    //warnings.innerHTML = "<b>1111111" + response.routes[0].warnings + "</b>";
        directionsDisplay.setDirections(response);
        showSteps(response);
      }
	})
	
	}



  function showSteps(directionResult) {
    // For each step, place a marker, and add the text to the marker
    // info window. Also attach the marker to an array so we
    // can keep track of it and remove it when calculating new
    // routes.
	var distance = 0;
	var duration = 0;
	if (!multiRoute) {

	    myRoute = directionResult.routes[0].legs[0];
	    for (var i = 0; i < myRoute.steps.length; i++) {
//			distance += myRoute.steps[i].distance.value;
//			duration += myRoute.steps[i].duration.value;
//			document.getElementById("route").innerHTML += myRoute.steps[i].instructions + "<br />";


			if (i == 0) {
				markers[0] = new google.maps.Marker({
					position: myRoute.steps[i].start_point,
					map: map
				});

			 	infoWindows[0] = new google.maps.InfoWindow({
				    content: "<div id=\'map0\' style=\'width:300px;height:200px;\'></div>"
				});
				google.maps.event.addListener(markers[0], "click", function() {
				  	infoWindows[0].open(map,markers[0]);
					setTimeout("startInfoWindowMap()", 1000);
				});
			}

			if (i == myRoute.steps.length - 1) {
				markers[1] = new google.maps.Marker({
					position: myRoute.steps[i].end_point,
					map: map
				});

			 	infoWindows[1] = new google.maps.InfoWindow({
				    content: "<div id=\'map1\' style=\'width:300px;height:200px;\'></div>"
				});
				google.maps.event.addListener(markers[1], "click", function() {
				  	infoWindows[1].open(map,markers[1]);
					setTimeout("endInfoWindowMap()", 1000);

				});
			}

	    }
	    
	    
	}
	else { // multiRoute
	    myRoute = directionResult.routes[0];
        for (var j = 0; j < myRoute.legs.length; j++) {
		    for (var i = 0; i < myRoute.legs[j].steps.length; i++) {
				distance += myRoute.legs[j].steps[i].distance.value;
				duration += myRoute.legs[j].steps[i].duration.value;
//				document.getElementById("route").innerHTML += myRoute.legs[j].steps[i].instructions + "<br />";
		    }
		}
	}

	var hours = parseInt(duration / 3600);
	var mins = parseInt((duration - 3600 * hours) / 60);
    distance = (parseInt(distance / 100.) / 10.) + "";

  }

  function attachInstructionText(marker, text) {
    google.maps.event.addListener(marker, "click", function() {
      // Open an info window when the marker is clicked on,
      // containing the text of the step.
      stepDisplay.setContent(text);
      stepDisplay.open(map, marker);
    });
  }

}

function startInfoWindowMap() {
	// the map in the infoWindow at route begin
	var myOptions0 = {
	  zoom: 15,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  center: myRoute.steps[0].start_point
	}
	while(!document.getElementById("map0")) {}
	map0 = new google.maps.Map(document.getElementById("map0"), myOptions0);
	var request0 = {
	    origin: "$start",
	    destination: "$end",
	    travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	var rendererOptions0 = {
		  suppressMarkers: false,
		  preserveViewport: true,
		  map: map0
	}
	directionsDisplay0 = new google.maps.DirectionsRenderer(rendererOptions0);
	// Route the directions and pass the response to a
	// function to create markers for each step.
	directionsService.route(request0, function(response0, status) {
	  if (status == google.maps.DirectionsStatus.OK) {
	    directionsDisplay0.setDirections(response0);
	  }
	});
}

function endInfoWindowMap() {
	// the map in the infoWindow at end of route
	var myOptions1 = {
	  zoom: 15,
	  mapTypeId: google.maps.MapTypeId.ROADMAP,
	  center: myRoute.steps[myRoute.steps.length - 1].end_point
	}
	while(! document.getElementById("map1")) {}
	map1 = new google.maps.Map(document.getElementById("map1"), myOptions1);
	var request1 = {
	    origin: "$start",
	    destination: "$end",
	    travelMode: google.maps.DirectionsTravelMode.DRIVING
	};
	var rendererOptions1 = {
		  suppressMarkers: false,
		  preserveViewport: true,
		  map: map1
	}
	directionsDisplay1 = new google.maps.DirectionsRenderer(rendererOptions1);
	// Route the directions and pass the response to a
	// function to create markers for each step.
	directionsService.route(request1, function(response1, status) {
	  if (status == google.maps.DirectionsStatus.OK) {
	    directionsDisplay1.setDirections(response1);
	  }
	});

}
		</script>';

		return $out;
	 }
	 
	 
}

?>