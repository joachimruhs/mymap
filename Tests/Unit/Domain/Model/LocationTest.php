<?php

namespace WSR\Mymap\Tests\Unit\Domain\Model;

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
 * Test case for class \WSR\Mymap\Domain\Model\Location.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Joachim Ruhs <postmaster@joachim-ruhs.de>
 */
class LocationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \WSR\Mymap\Domain\Model\Location
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = new \WSR\Mymap\Domain\Model\Location();
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName() {
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForStringSetsAddress() {
		$this->subject->setAddress('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'address',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getZipcodeReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getZipcode()
		);
	}

	/**
	 * @test
	 */
	public function setZipcodeForStringSetsZipcode() {
		$this->subject->setZipcode('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'zipcode',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCityReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getCity()
		);
	}

	/**
	 * @test
	 */
	public function setCityForStringSetsCity() {
		$this->subject->setCity('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'city',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCountryReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getCountry()
		);
	}

	/**
	 * @test
	 */
	public function setCountryForStringSetsCountry() {
		$this->subject->setCountry('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'country',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPhoneReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getPhone()
		);
	}

	/**
	 * @test
	 */
	public function setPhoneForStringSetsPhone() {
		$this->subject->setPhone('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'phone',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getFaxReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getFax()
		);
	}

	/**
	 * @test
	 */
	public function setFaxForStringSetsFax() {
		$this->subject->setFax('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'fax',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMobileReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getMobile()
		);
	}

	/**
	 * @test
	 */
	public function setMobileForStringSetsMobile() {
		$this->subject->setMobile('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'mobile',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getEmail()
		);
	}

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail() {
		$this->subject->setEmail('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'email',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() {
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLatReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getLat()
		);
	}

	/**
	 * @test
	 */
	public function setLatForStringSetsLat() {
		$this->subject->setLat('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'lat',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLonReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getLon()
		);
	}

	/**
	 * @test
	 */
	public function setLonForStringSetsLon() {
		$this->subject->setLon('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'lon',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getGeocodeReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getGeocode()
		);
	}

	/**
	 * @test
	 */
	public function setGeocodeForIntegerSetsGeocode() {
		$this->subject->setGeocode(12);

		$this->assertAttributeEquals(
			12,
			'geocode',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getIconReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getIcon()
		);
	}

	/**
	 * @test
	 */
	public function setIconForIntegerSetsIcon() {
		$this->subject->setIcon(12);

		$this->assertAttributeEquals(
			12,
			'icon',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getImage()
		);
	}

	/**
	 * @test
	 */
	public function setImageForIntegerSetsImage() {
		$this->subject->setImage(12);

		$this->assertAttributeEquals(
			12,
			'image',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMediaReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->subject->getMedia()
		);
	}

	/**
	 * @test
	 */
	public function setMediaForIntegerSetsMedia() {
		$this->subject->setMedia(12);

		$this->assertAttributeEquals(
			12,
			'media',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCategoriesReturnsInitialValueForCategory() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getCategories()
		);
	}

	/**
	 * @test
	 */
	public function setCategoriesForObjectStorageContainingCategorySetsCategories() {
		$category = new \WSR\Mymap\Domain\Model\Category();
		$objectStorageHoldingExactlyOneCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneCategories->attach($category);
		$this->subject->setCategories($objectStorageHoldingExactlyOneCategories);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneCategories,
			'categories',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addCategoryToObjectStorageHoldingCategories() {
		$category = new \WSR\Mymap\Domain\Model\Category();
		$categoriesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$categoriesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($category));
		$this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

		$this->subject->addCategory($category);
	}

	/**
	 * @test
	 */
	public function removeCategoryFromObjectStorageHoldingCategories() {
		$category = new \WSR\Mymap\Domain\Model\Category();
		$categoriesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$categoriesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($category));
		$this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

		$this->subject->removeCategory($category);

	}
}
