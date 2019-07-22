<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mymap".
 *
 * Auto generated 21-11-2018 17:58
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'MyMap',
  'description' => 'Google maps with radial search and hierarchic categories (category tree). Show the results in responsive Google maps, traffic- and bicycling layer included and can be activated via constant editor.',
  'category' => 'plugin',
  'version' => '0.7.3-dev',
  'state' => 'beta',
  'uploadfolder' => true,
  'createDirs' => 'uploads/tx_mymap/media,uploads/tx_mymap/images,uploads/tx_mymap/icons',
  'clearcacheonload' => false,
  'author' => 'Joachim Ruhs',
  'author_email' => 'postmaster@joachim-ruhs.de',
  'author_company' => 'Web Services Ruhs',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.0-9.5.99',
      'vhs' => '2.4.0',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
);

