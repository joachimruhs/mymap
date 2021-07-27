<?php
namespace WSR\Mymap\Controller;


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