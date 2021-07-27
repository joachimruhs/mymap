<?php

namespace WSR\Mymap\Event;

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

class SearchViewEvent
{

    /**
     * locations
     * 
     * @var array
     */
	protected $locations = [];	

    public function setLocations($locations): void
    {
		$this->locations = $locations;
	}	
    public function getLocations()
    {
		return $this->locations;
	}	

}