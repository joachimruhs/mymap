<?php
namespace WSR\Mymap\Domain\Model;


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
 * Location
 */
class Location extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

		/**
		* startup
		* 
		* @var \DateTime
		*/
		protected $startup;

		/**
		* Returns startup
		* 
		* @return integer $startup
		*/
		public function getStartup() {
			return $this->startup;
		}
		
		/**
		* Sets startup
		* 
		* @param integer $startup
		* @return void
		*/
		public function setStartup($startup) {
			$this->startup = $startup;
		}



        /**
         * Images
         * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
         */
        protected $images;

        /**
         * Files
         * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
         */
        protected $files;

		

		/**
		* Returns the images
		*
		* @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
		*/
		public function getImages() {
		   return $this->images;
		}
	   
		/**
		* Sets the images
		*
		* @return void
		*/
		public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images) {
		   $this->images = $images;
		}
			   
			   
		
		

        /**
         * Returns the files
         *
         * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $files
         */
        public function getFiles() {
                return $this->files;
        }

        /**
         * Sets the files
         *
         * @return void
         */
        public function setFiles($files) {
                $this->files = $files;
        }
        


	/**
	 * name
	 * 
	 * @var string
	 */
	protected $name = '';

	/**
	 * additionalname
	 * 
	 * @var string
	 */
	protected $additionalname = '';


	/**
	 * address
	 * 
	 * @var string
	 */
	protected $address = '';

	/**
	 * additionaladdress
	 * 
	 * @var string
	 */
	protected $additionaladdress = '';


	/**
	 * zipcode
	 * 
	 * @var string
	 */
	protected $zipcode = '';

	/**
	 * city
	 * 
	 * @var string
	 */
	protected $city = '';

	/**
	 * country
	 * 
	 * @var string
	 */
	protected $country = '';

	/**
	 * additionalcontact
	 * 
	 * @var string
	 */
	protected $additionalcontact = '';

	/**
	 * phone
	 * 
	 * @var string
	 */
	protected $phone = '';

	/**
	 * fax
	 * 
	 * @var string
	 */
	protected $fax = '';

	/**
	 * mobile
	 * 
	 * @var string
	 */
	protected $mobile = '';

	/**
	 * email
	 * 
	 * @var string
	 */
	protected $email = '';

	/**
	 * www
	 * 
	 * @var string
	 */
	protected $www = '';

	/**
	 * description
	 * 
	 * @var string
	 */
	protected $description = '';

	/**
	 * kwp
	 * 
	 * @var float
	 */
	protected $kwp = 0.0;

	/**
	 * lat
	 * 
	 * @var string
	 */
	protected $lat = '';

	/**
	 * lon
	 * 
	 * @var string
	 */
	protected $lon = '';

	/**
	 * geocode
	 * 
	 * @var integer
	 */
	protected $geocode = 0;

	/**
	 * icon
	 * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $icon = '';

	/**
	 * image
	 * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $image = '';

	/**
	 * media
	 * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $media = '';

	/**
	 * categories
	 * 
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\WSR\Mymap\Domain\Model\Category>
	 */
	protected $categories = NULL;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 * 
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 * 
	 * @return string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 * 
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the additionalname
	 * 
	 * @return string $additionalname
	 */
	public function getAdditionalname() {
		return $this->additionalname;
	}

	/**
	 * Sets the additionalname
	 * 
	 * @param string $additionalname
	 * @return void
	 */
	public function setAdditionalname($additionalname) {
		$this->additionalname = $additionalname;
	}


	/**
	 * Returns the additionalcontact
	 * 
	 * @return string $additionalcontact
	 */
	public function getAdditionalcontact() {
		return $this->additionalcontact;
	}

	/**
	 * Sets the additionalcontact
	 * 
	 * @param string $additionalcontact
	 * @return void
	 */
	public function setAdditionalcontact($additionalcontact) {
		$this->additionalname = $additionalcontact;
	}




	/**
	 * Returns the address
	 * 
	 * @return string $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 * 
	 * @param string $address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the additionaladdress
	 * 
	 * @return string $additionaladdress
	 */
	public function getAdditionaladdress() {
		return $this->additionaladdress;
	}

	/**
	 * Sets the additionaladdress
	 * 
	 * @param string $additionaladdress
	 * @return void
	 */
	public function setAdditionaladdress($additionaladdress) {
		$this->additionaladdress = $additionaladdress;
	}






	/**
	 * Returns the zipcode
	 * 
	 * @return string $zipcode
	 */
	public function getZipcode() {
		return $this->zipcode;
	}

	/**
	 * Sets the zipcode
	 * 
	 * @param string $zipcode
	 * @return void
	 */
	public function setZipcode($zipcode) {
		$this->zipcode = $zipcode;
	}

	/**
	 * Returns the city
	 * 
	 * @return string $city
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * Sets the city
	 * 
	 * @param string $city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the country
	 * 
	 * @return string $country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the country
	 * 
	 * @param string $country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the phone
	 * 
	 * @return string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 * 
	 * @param string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the fax
	 * 
	 * @return string $fax
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets the fax
	 * 
	 * @param string $fax
	 * @return void
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Returns the mobile
	 * 
	 * @return string $mobile
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * Sets the mobile
	 * 
	 * @param string $mobile
	 * @return void
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}

	/**
	 * Returns the email
	 * 
	 * @return string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Returns the www
	 * 
	 * @return string $www
	 */
	public function getWww() {
		return $this->www;
	}

	/**
	 * Sets the email
	 * 
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Sets the www
	 * 
	 * @param string $www
	 * @return void
	 */
	public function setWww($www) {
		$this->www = $www;
	}

	/**
	 * Returns the description
	 * 
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 * 
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}


	/**
	 * Returns the kwp
	 * 
	 * @return float $kwp
	 */
	public function getKwp() {
		return $this->kwp;
	}

	/**
	 * Sets the kwp
	 * 
	 * @param float $kwp
	 * @return void
	 */
	public function setKwp($kwp) {
		$this->kwp = $kwp;
	}


	/**
	 * Returns the lat
	 * 
	 * @return string $lat
	 */
	public function getLat() {
		return $this->lat;
	}

	/**
	 * Sets the lat
	 * 
	 * @param string $lat
	 * @return void
	 */
	public function setLat($lat) {
		$this->lat = $lat;
	}

	/**
	 * Returns the lon
	 * 
	 * @return string $lon
	 */
	public function getLon() {
		return $this->lon;
	}

	/**
	 * Sets the lon
	 * 
	 * @param string $lon
	 * @return void
	 */
	public function setLon($lon) {
		$this->lon = $lon;
	}

	/**
	 * Returns the geocode
	 * 
	 * @return integer $geocode
	 */
	public function getGeocode() {
		return $this->geocode;
	}

	/**
	 * Sets the geocode
	 * 
	 * @param integer $geocode
	 * @return void
	 */
	public function setGeocode($geocode) {
		$this->geocode = $geocode;
	}

	/**
	 * Returns the icon
	 * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	public function getIcon() {
		return $this->icon;
	}

	/**
	 * Sets the icon
	 * 
	 * @param FileReference $icon
	 * @return void
	 */
	public function setIcon($icon) {
		$this->icon = $icon;
	}

	/**
	 * Returns the image
	 * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 * 
	 * @param FileReference $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the media
	 * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * Sets the media
	 * 
	 * @param FileReference $media
 	 * @return void
	 */
	public function setMedia($media) {
		$this->media = $media;
	}

	/**
	 * Adds a Category
	 * 
	 * @param \WSR\Mymap\Domain\Model\Category $category
	 * @return void
	 */
	public function addCategory(\WSR\Mymap\Domain\Model\Category $category) {
		$this->categories->attach($category);
	}

	/**
	 * Removes a Category
	 * 
	 * @param \WSR\Mymap\Domain\Model\Category $categoryToRemove The Category to be removed
	 * @return void
	 */
	public function removeCategory(\WSR\Mymap\Domain\Model\Category $categoryToRemove) {
		$this->categories->detach($categoryToRemove);
	}

	/**
	 * Returns the categories
	 * 
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\WSR\Mymap\Domain\Model\Category> $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * Sets the categories
	 * 
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\WSR\Mymap\Domain\Model\Category> $categories
	 * @return void
	 */
	public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) {
		$this->categories = $categories;
	}

}