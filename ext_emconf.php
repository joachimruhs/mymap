<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mymap".
 *
 * Auto generated 27-05-2020 18:41
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'MyMap',
  'description' => 'Google maps with radial search and hierarchic categories (category tree). Show the results in responsive Google maps, traffic- and bicycling layer included and can be activated via constant editor.',
  'category' => 'plugin',
  'version' => '0.8.2',
  'state' => 'beta',
  'uploadfolder' => true,
  'clearcacheonload' => false,
  'author' => 'Joachim Ruhs',
  'author_email' => 'postmaster@joachim-ruhs.de',
  'author_company' => 'Web Services Ruhs',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '9.5.0-10.4.99',
      'vhs' => '6.0.0',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'createDirs' => NULL,
);

