<?php
namespace WSR\Mymap\Domain\Repository;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
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
 * The repository for Categories
 */
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


  /**
    * Finds all categories ordered by name
    * @return Tx_Extbase_Persistence_QueryResultInterface The categories
	*/
	public function findAll() {
		$query = $this->createQuery();
		$query->setOrderings (Array('name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING));
		return $query->execute();
	}




  /**
    * Finds categories by the specified location
    * @param int $uid
	* @return array categories
	*/
	public function findCategoriesByLocation($uid) {
		$query = $this->createQuery();
		$query->statement('SELECT GROUP_CONCAT(b.name ORDER BY b.name SEPARATOR ", ") as categories from tx_mymap_domain_model_location a,
						  tx_mymap_domain_model_category b where a.uid=' . intval($uid) . ' AND find_in_set(b.uid, a.category)');
		return $query->execute(TRUE);
	}

	public function findAllOverwrite() {
		$query = $this->createQuery();
		return $query->execute(TRUE);
		
	}


	function buildTree(array &$elements, $parentId = 0) {
		$branch = array();
		foreach ($elements as &$element) {
			if ($element['parent'] == $parentId) {
				$children = $this->buildTree($elements, $element['uid']);
				if ($children) {
					$element['children'] = $children;
				}
				$branch[$element['uid']] = $element;
				unset($element);
			}
		}
		return $branch;
	}


	
}