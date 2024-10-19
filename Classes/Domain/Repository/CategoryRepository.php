<?php
namespace WSR\Mymap\Domain\Repository;

use TYPO3\CMS\Core\Utility\GeneralUtility;
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

	public function findAllOverwrite($pid) {
		$queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)
			->getQueryBuilderForTable('tx_mymap_domain_model_category');

		$queryBuilder
		->getRestrictions()
		->removeAll();

		$queryBuilder->select('*')
		->from('tx_mymap_domain_model_category')
		->where(
			$queryBuilder->expr()->eq(
				'pid',
				$queryBuilder->createNamedParameter($pid, Connection::PARAM_INT)
			)
		)			
		->andWhere($queryBuilder->expr()->and(
				$queryBuilder->expr()->and(
					$queryBuilder->expr()->eq('hidden', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT))
				),
				$queryBuilder->expr()->and(
					$queryBuilder->expr()->gte('deleted', $queryBuilder->createNamedParameter(0, Connection::PARAM_INT))
				)
			)
		);
		$result = $queryBuilder->executeQuery()->fetchAllAssociative();
		return $result;		
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
