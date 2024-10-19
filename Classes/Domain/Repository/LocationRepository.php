<?php
namespace WSR\Mymap\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Connection;
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
 * The repository for Locations
 */
class LocationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Fetches the locations for geocoding
	 *
	 * @return array
	 */
	public function updateLatLon($pid) {
		$queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable('tx_mymap_domain_model_location');

		$queryBuilder
		->getRestrictions()
		->removeAll()
		->add(GeneralUtility::makeInstance(DeletedRestriction::class))
		->add(GeneralUtility::makeInstance(HiddenRestriction::class));
		
		$queryBuilder->select('*')
		->from('tx_mymap_domain_model_location')
		->where(
			$queryBuilder->expr()->eq(
				'pid',
				$queryBuilder->createNamedParameter($pid, Connection::PARAM_INT)
			)
		)			
		->andWhere($queryBuilder->expr()->and(
				$queryBuilder->expr()->and(
					$queryBuilder->expr()->eq('lat', $queryBuilder->createNamedParameter('', Connection::PARAM_STR))
				),
				$queryBuilder->expr()->and(
					$queryBuilder->expr()->gte('lon', $queryBuilder->createNamedParameter('', Connection::PARAM_STR))
				)
			)
		);
		$result = $queryBuilder->executeQuery()->fetchAllAssociative();
		return $result;		
	}

	/**
	 * Sets lat lon 
	 *
	 * @return void
	 */
	public function setLatLon($uid, $lat, $lon) {
		$queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable('tx_mymap_domain_model_location');
		$queryBuilder->update('tx_mymap_domain_model_location')
	   ->where(
		$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
		)
		->set('lat', $lat)
		->set('lon', $lon)
		->executeQuery();		
	}
	
	/**
	 * Get location with uid
	 *
	 * @return array
	 */
	public function findLocationUidOverride($uid) {
		$queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable('tx_mymap_domain_model_location');

		$queryBuilder
		->getRestrictions()
		->removeAll()
		->add(GeneralUtility::makeInstance(DeletedRestriction::class))
		->add(GeneralUtility::makeInstance(HiddenRestriction::class));


		$queryBuilder->select('*')
		->from('tx_mymap_domain_model_location')
	   ->where(
			$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT))
		);
		$result = $queryBuilder->executeQuery()->fetchAllAssociative();
		return $result;		

	}




	/**
	 * Find locations within radius
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
		$pi = M_PI;
		$lat = $latLon->lat;
		$lon =  $latLon->lon;
		$query = $this->createQuery();



		if ($categories)
			$categories = GeneralUtility::intExplode(',', $categories, true);		

        $categorySelect	= '';
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
				WHERE a.name LIKE '%' " . $categorySelect . " AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ")
				having distance <= " . intval($radius) . " order by distance limit " . $limit )->execute(TRUE);

	} else {
		$result = $query->statement("SELECT distinct a.*, (((acos(sin(($lat*$pi/180)) * sin((lat*$pi/180)) + cos(($lat*$pi/180)) *  cos((lat*$pi/180)) * cos((($lon - lon)*$pi/180)))))*6370) as distance 
	
			, (SELECT GROUP_CONCAT(c.name ORDER BY name SEPARATOR ', ') as categories from tx_mymap_domain_model_category c
			where find_in_set(c.uid, a.category)) as categories 
	
			FROM tx_mymap_domain_model_location a  
				WHERE a.name LIKE '%' AND a.hidden = 0 AND a.deleted = 0 AND a.pid in (" . $storagePid . ")
				having distance <= " . intval($radius) . " order by distance limit " . $limit )->execute(TRUE);
		
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
        $categorySelect	= '';
		if (is_array($categories)) {
			for ($i = 0; $i < count($categories); $i++) {
				if ($categories[$i]) {
					if ($i == 0) {
					$categorySelect .= ' AND ((find_in_set(' . intval($categories[$i]) . ', a.category))';
					} else {
					$categorySelect .= ' OR (find_in_set(' . intval($categories[$i]) . ', a.category))';
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
									AND a.fieldname='images' AND a.uid_local = b.uid AND a.deleted = 0 AND a.uid_foreign = " . intval($uid) ." order by b.identifier" )-> execute(true);
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
									AND a.fieldname='files' AND a.uid_local = b.uid AND a.deleted = 0 AND a.uid_foreign = " . intval($uid) ." order by b.identifier" )-> execute(true);
		return $result;
	}


	
}
