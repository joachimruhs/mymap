<?php
namespace WSR\Mymap\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;


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
 *
 *
 * @package TYPO3
 * @subpackage mymap
 *
 */


class GetCategoriesViewHelper extends AbstractViewHelper {

	/**
	* Arguments Initialization
	*/
	public function initializeArguments(): void {
		$this->registerArgument('categories', 'array', 'The categories', TRUE);
		$this->registerArgument('index', 'int', 'The index', TRUE);
	}

    /**
	* Returns categories comma separated
	* @param array $arguments
    * @param \Closure $renderChildrenClosure
    * @param RenderingContextInterface $renderingContext
	* @return string categories comma separated
	*/
    public function render() {
		$index = $this->arguments['index'];
		return $this->arguments['categories'][$index];
	}
}
?>