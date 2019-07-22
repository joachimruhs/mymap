<?php
namespace WSR\Mymap\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 - 2018 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
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

/**
 * The repository for Locations
 */
class LocationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Updates lat lon 
	 *
	 * @return void
	 */
	public function updateLatLon() {
		$query = $this->createQuery();
		$query->setLimit(25);
		return $query->matching(
								$query->logicalAnd(
												   $query->equals('lat', ''),
												   $query->equals('lon', ''),
												   $query->equals('geocode', 1)
												   )
								)
			->execute();
		
	}

	
	/**
	 * Find locaztions within radius
	 *
	 * @param stdClass  $latLon
	 * @param int  $radius
	 * @param array $categories
	 * @param int  $limit
	 * @param int  $page
	 * 
	 * @return Tx_Extbase_Persistence_QueryResultInterface The locations
	 */
	public function findLocationsInRadius($latLon, $radius, $categories, $storagePid, $limit, $page) {
		$radius = intval($radius);
		$pi = M_PI;
		$lat = $latLon->lat;
		$lon =  $latLon->lon;
		$query = $this->createQuery();



		if ($categories)
			$categories = explode(',', $categories);
			
		if (is_array($categories)) {
			for ($i = 0; $i < count($categories); $i++) {
				if ($categories[$i]) {
					if ($i == 0) {
					$categorySelect .= ' AND ((find_in_set(' . $categories[$i] . ', a.category))';
					} else {
					$categorySelect .= ' OR (find_in_set(' . $categories[$i] . ', a.category))';
					}
				}
			}	
		}
		if ($categorySelect) $categorySelect .= ')';


/*
if ($page) {
		$limit = intval($page * $limit) . ',' . intval($limit);
} else {
	$limit = intval($limit);
}
*/


		$limit = intval($page * $limit) . ',' . intval($limit);

//if ($page == -1) $limit = 1000;


	if ($categorySelect) {
		$result = $query->statement("SELECT distinct a.*, (((acos(sin(($lat*$pi/180)) * sin((lat*$pi/180)) + cos(($lat*$pi/180)) *  cos((lat*$pi/180)) * cos((($lon - lon)*$pi/180)))))*6370) as distance 
	
			, (SELECT GROUP_CONCAT(c.name ORDER BY name SEPARATOR ', ') as categories from tx_mymap_domain_model_category c
			where find_in_set(c.uid, a.category)) as categories 
			 
	
			FROM tx_mymap_domain_model_location a, tx_mymap_domain_model_category c 
				WHERE a.name LIKE '%' " . $categorySelect . " AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ") having distance <= $radius order by distance limit " . $limit )->execute(TRUE);

	} else {
		$result = $query->statement("SELECT distinct a.*, (((acos(sin(($lat*$pi/180)) * sin((lat*$pi/180)) + cos(($lat*$pi/180)) *  cos((lat*$pi/180)) * cos((($lon - lon)*$pi/180)))))*6370) as distance 
	
			, (SELECT GROUP_CONCAT(c.name ORDER BY name SEPARATOR ', ') as categories from tx_mymap_domain_model_category c
			where find_in_set(c.uid, a.category)) as categories 
	
			FROM tx_mymap_domain_model_location a  
				WHERE a.name LIKE '%' AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ") having distance <= $radius order by distance limit " . $limit )->execute(TRUE);
		
	}		

		return $result;
	}



	/**
	 * Find counts of locations of a category
	 *
	 * @param int  $uid
	 */	
	public function findCountsByCategory($uid) {
		$time = time();
		$startStopp = " AND (a.starttime = 0 OR a.starttime <= $time) AND (a.endtime = 0 OR a.endtime > $time) AND a.deleted = 0 AND a.hidden = 0";

		$query = $this->createQuery();
		$result = $query->statement("SELECT uid, count(*) as counts 
		FROM tx_mymap_domain_model_location a
		    WHERE find_in_set(" . intval($uid) . ", category) $startStopp" )->execute(TRUE);
		return $result;
	}



	
	public function findAllOverwrite() {
		$query = $this->createQuery();

//		$query->getQuerySettings()->setRespectStoragePage(FALSE);

		$query->setOrderings(array("name" => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING)); 
		return $query->execute(true);

	}

	public function findAllByCategory($latLon, $radius, $categories, $storagePid, $limit, $page) {
		if (is_array($categories)) {
			for ($i = 0; $i < count($categories); $i++) {
				if ($categories[$i]) {
					if ($i == 0) {
					$categorySelect .= ' AND ((find_in_set(' . $categories[$i] . ', a.category))';
					} else {
					$categorySelect .= ' OR (find_in_set(' . $categories[$i] . ', a.category))';
					}
				}
			}	
		}
		if ($categorySelect) $categorySelect .= ')';

		
		$query = $this->createQuery();

		if ($categories) {
			$result = $query->statement("SELECT distinct a.* 
		
				, (SELECT GROUP_CONCAT(c.name ORDER BY name SEPARATOR ', ') as categories from tx_mymap_domain_model_category c
				where c.uid in (a.category)) as categories 
		
				FROM tx_mymap_domain_model_location a, tx_mymap_domain_model_category c 
					WHERE a.name LIKE '%' " . $categorySelect . " AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ") " )->execute(TRUE);

		} else {
			$result = $query->statement("SELECT distinct a.* 
		
				, (SELECT GROUP_CONCAT(c.name ORDER BY name SEPARATOR ', ') as categories from tx_mymap_domain_model_category c
				where c.uid in (a.category)) as categories 
		
				FROM tx_mymap_domain_model_location a
					WHERE a.name LIKE '%' AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ") " )->execute(TRUE);
			
		}		

		return $result;
	}


	
	/**
	 * Get images of location uid
	 *
	 * @return array
	 */
	public function getImages1($uid) {
		$query = $this->createQuery();
		$result = $query->statement("SELECT * from sys_file_reference a, sys_file b where tablenames = 'tx_mymap_domain_model_location'
									AND a.fieldname='images' AND a.uid_local = b.uid AND a.deleted = 0 AND a.uid_foreign = " . $uid ." order by b.identifier" )-> execute(true);
		return $result;
	}

	/**
	 * Get files of location uid
	 *
	 * @return array
	 */
	public function getFiles1($uid) {
		$query = $this->createQuery();
		$result = $query->statement("SELECT * from sys_file_reference a, sys_file b where tablenames = 'tx_mymap_domain_model_location'
									AND a.fieldname='files' AND a.uid_local = b.uid AND a.deleted = 0 AND a.uid_foreign = " . $uid ." order by b.identifier" )-> execute(true);
		return $result;
	}


	
}