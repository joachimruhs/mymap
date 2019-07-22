<?php
namespace WSR\Mymap\Controller;


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
 * CategoryController
 */
class CategoryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * categoryRepository
	 * 
	 * @var \WSR\Mymap\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository = NULL;

    /**
     * Inject a categoryRepository to enable DI
     *
     * @param \WSR\Mymap\Domain\Repository\CategoryRepository $categoryRepository
     * @return void
     */
    public function injectCategoryRepository(\WSR\Mymap\Domain\Repository\CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

	
	
	
	/**
	 * action list
	 * 
	 * @return void
	 */
	public function listAction() {
		$categories = $this->categoryRepository->findAll();
		$this->view->assign('categories', $categories);
	}

	/**
	 * action show
	 * 
	 * @param \WSR\Mymap\Domain\Model\Category $category
	 * @return void
	 */
	public function showAction(\WSR\Mymap\Domain\Model\Category $category) {
		$this->view->assign('category', $category);
	}

}