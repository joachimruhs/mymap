<?php
namespace WSR\Mymap\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Joachim Ruhs <postmaster@joachim-ruhs.de>, Web Services Ruhs
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class WSR\Mymap\Controller\CategoryController.
 *
 * @author Joachim Ruhs <postmaster@joachim-ruhs.de>
 */
class CategoryControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \WSR\Mymap\Controller\CategoryController
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = $this->getMock('WSR\\Mymap\\Controller\\CategoryController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllCategoriesFromRepositoryAndAssignsThemToView() {

		$allCategories = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$categoryRepository = $this->getMock('WSR\\Mymap\\Domain\\Repository\\CategoryRepository', array('findAll'), array(), '', FALSE);
		$categoryRepository->expects($this->once())->method('findAll')->will($this->returnValue($allCategories));
		$this->inject($this->subject, 'categoryRepository', $categoryRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('categories', $allCategories);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenCategoryToView() {
		$category = new \WSR\Mymap\Domain\Model\Category();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('category', $category);

		$this->subject->showAction($category);
	}
}
