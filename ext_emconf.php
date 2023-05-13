<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mymap".
 *
 * Auto generated 05-10-2022 12:49
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'MyMap',
  'description' => 'Google maps with radial search and hierarchic categories (category tree). Show the results in responsive Google maps, traffic- and bicycling layer included and can be activated via constant editor.',
  'category' => 'plugin',
  'version' => '1.6.1',
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
      'typo3' => '11.5.0-12.5.99',
#      'vhs' => '6.0.0',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
);

