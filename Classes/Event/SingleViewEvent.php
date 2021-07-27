<?php

namespace WSR\Mymap\Event;

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


class SingleViewEvent
{
    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * location
     * 
     * @var array
     */
	protected $location = [];	
	
/*	
    public function modifyLocation($location): void
    {
    }
*/	
    public function setName($name): void
    {
		$this->name = $name;
	}	
	
    public function getName(): string
    {
		return $this->name;
	}	

    public function setLocation($location): void
    {
		$this->location = $location;
	}	
    public function getLocation()
    {
		return $this->location;
	}	

}