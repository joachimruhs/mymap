<?php
namespace WSR\Mymap;

/*
 * This file is adopted and modified from the maps2 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use WSR\Mymap\Utility\DatabaseUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageRendererResolver;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Update class for the extension manager.
 */
class ext_update
{
    /**
     * Array of flash messages (params) array[][status,title,message]
     *
     * @var array
     */
    protected $messageArray = [];

    /**
     * @var iconsToUpdate
     */
    protected $iconsToUpdate;

    /**
     * @var imagesToUpdate
     */
    protected $imagesToUpdate;

    /**
     * @var mediaToUpdate
     */
    protected $mediaToUpdate;


    /**
     * Main update function called by the extension manager.
     *
     * @return string
     */
    public function main()
    {
        $this->processUpdates();
        return $this->generateOutput();
    }

    /**
     * Called by the extension manager to determine if the update menu entry
     * should by showed.
     *
     * @return bool
     */
    public function access()
    {
        $showAccess = false;
		
        // check for old icons in field
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
        $this->iconsToUpdate = $queryBuilder
            ->count('*')
            ->from('tx_mymap_domain_model_location')
			->where(
				$queryBuilder->expr()->orX( 
					$queryBuilder->expr()->like(
						'icon',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.png'))
					),
					$queryBuilder->expr()->like(
						'icon',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpg'))
					),
					$queryBuilder->expr()->like(
						'icon',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpeg'))
					),
					$queryBuilder->expr()->like(
						'icon',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.gif'))
					)

				)

			)
            ->execute()
            ->fetchColumn(0);

			
        if ((bool)$this->iconsToUpdate) {
            $showAccess = true;
        }

        // check for old images
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
        $this->imagesToUpdate = $queryBuilder
            ->count('*')
            ->from('tx_mymap_domain_model_location')
			->where(
				$queryBuilder->expr()->orX( 
					$queryBuilder->expr()->like(
						'image',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.png'))
					),
					$queryBuilder->expr()->like(
						'image',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpg'))
					),
					$queryBuilder->expr()->like(
						'image',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpeg'))
					),
					$queryBuilder->expr()->like(
						'image',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.gif'))
					)

				)

			)
            ->execute()
            ->fetchColumn(0);
			
			
			
        if ((bool)$this->imagesToUpdate) {
            $showAccess = true;
        }

        // check for old media
        $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
        $this->mediaToUpdate = $queryBuilder
            ->count('*')
            ->from('tx_mymap_domain_model_location')
			->where(
				$queryBuilder->expr()->orX( 
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.png'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpg'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.jpeg'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.gif'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.wmv'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.mp3'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.mp4'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.ogg'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.wav'))
					),
					$queryBuilder->expr()->like(
						'media',
						$queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('.webm'))
					)
					

				)

			)
            ->execute()
            ->fetchColumn(0);

			
        if ((bool)$this->mediaToUpdate) {
            $showAccess = true;
        }


/*		
        // check for old marker_icon column in sys_category
        $fields = DatabaseUtility::getColumnsFromTable('sys_category');
        if (array_key_exists('marker_icon', $fields)) {
            $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('sys_category');
            $queryBuilder->getRestrictions()->removeAll()->add(
                GeneralUtility::makeInstance(DeletedRestriction::class)
            );
            $amountOfRecords = $queryBuilder
                ->count('*')
                ->from('sys_category')
                ->where(
                    $queryBuilder->expr()->neq(
                        'marker_icon',
                        $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                    )
                )
                ->execute()
                ->fetchColumn(0);
        }
        if ((bool)$amountOfRecords) {
            $showAccess = true;
        }
*/

        return $showAccess;
    }

    /**
     * The actual update function. Add your update task in here.
     *
     * @return void
     */
    protected function processUpdates()
    {
		try {
			/** @var File $file */
			$file = ResourceFactory::getInstance()->retrieveFileOrFolderObject('fileadmin/ENABLE_MYMAP_UPDATE_SCRIPT');
			if ($file instanceof FileInterface) {
				$this->migrateMarkerIconToFal();
				$this->migrateImageFieldToFal();
				$this->migrateMediaFieldToFal();
			}
		} catch (\Exception $e) {
			// file does not exists or whatever
			$this->messageArray[] = [
				FlashMessage::WARNING,
				'IMPORTANT: Before updating, backup the tables tx_mymap_domain_model_location and sys_file_reference',
				'To run the update script you have to create an empty file fileadmin/ENABLE_MYMAP_UPDATE_SCRIPT. See documentation...'
			];
			$this->generateOutput();
			return;
		}
		
    }


    /**
     * Migrate old marker icon of sys_category to FAL
     */
    protected function migrateMarkerIconToFal()
    {
        // check for old icon column in tx_mymap_domain_model_location first
        $fields = DatabaseUtility::getColumnsFromTable('tx_mymap_domain_model_location');
        if (array_key_exists('icon', $fields)) {
            $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
            $queryBuilder->getRestrictions()->removeAll()->add(
                GeneralUtility::makeInstance(DeletedRestriction::class)
            );
            $iconArray = $queryBuilder
                ->select('uid', 'pid', 'icon')
                ->from('tx_mymap_domain_model_location')
                ->where(
                    $queryBuilder->expr()->neq(
                        'icon',
                        $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                    )
                )
                ->execute()
                ->fetchAll();



			$migratedIcons = 0;
            if (is_array($iconArray)) {
                foreach ($iconArray as $iconObject) {
                    try {
						$oldIconField = 0;
                        /** @var File $file */
                        $file = ResourceFactory::getInstance()->retrieveFileOrFolderObject('uploads/tx_mymap/icons/' . $iconObject['icon']);
						// if $iconObject['icon'] is a number and not an image file nothing is done
                        if ($file instanceof FileInterface) {
                            // Assemble DataHandler data
                            $newId = 'NEW1234';
                            $data = [];
                            $data['sys_file_reference'][$newId] = [
                                'table_local' => 'sys_file',
                                'uid_local' => $file->getUid(),
                                'tablenames' => 'tx_mymap_domain_model_location',
                                'uid_foreign' => $iconObject['uid'],
                                'fieldname' => 'icon',
                                'pid' => $iconObject['pid']
                            ];
                            // Get an instance of the DataHandler and process the data
                            /** @var DataHandler $dataHandler */
                            $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
                            $dataHandler->start($data, []);
                            $dataHandler->process_datamap();
							
							$migratedIcons++;
							$oldIconField = 1;
							
                        }
                    } catch (\Exception $e) {
                        // file does not exists or whatever
                    }
                    // remove old icon
                    $connection = $this->getConnectionPool()->getConnectionForTable('tx_mymap_domain_model_location');
  
					if($oldIconField) {
						$connection->update(
							'tx_mymap_domain_model_location',
							[
								'icon' => $oldIconField
							],
							[
								'uid' => (int)$iconObject['uid']
							]
						);
					}
                }
                $this->messageArray[] = [
                    FlashMessage::OK,
                    'Migration successful',
                    sprintf(
                        'We have migrated %d icons to FAL',
                        $migratedIcons
                    )
                ];
            }
        }
    }


    /**
     * Migrate image field to FAL
     */
    protected function migrateImageFieldToFal()
    {
        // check for old image column in tx_mymap_domain_model_location first
        $fields = DatabaseUtility::getColumnsFromTable('tx_mymap_domain_model_location');
        if (array_key_exists('image', $fields)) {
            $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
            $queryBuilder->getRestrictions()->removeAll()->add(
                GeneralUtility::makeInstance(DeletedRestriction::class)
            );
            $imageArray = $queryBuilder
                ->select('uid', 'pid', 'image')
                ->from('tx_mymap_domain_model_location')
                ->where(
                    $queryBuilder->expr()->neq(
                        'image',
                        $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                    )
                )
                ->execute()
                ->fetchAll();
			$migratedImages = 0;

            if (is_array($imageArray)) {
                foreach ($imageArray as $imageObject) {
                    try {
						$oldImageField = 0;
                        /** @var File $file */
                        $file = ResourceFactory::getInstance()->retrieveFileOrFolderObject('uploads/tx_mymap/images/' . $imageObject['image']);
                        if ($file instanceof FileInterface) {
                            // Assemble DataHandler data
                            $newId = 'NEW1234';
                            $data = [];
                            $data['sys_file_reference'][$newId] = [
                                'table_local' => 'sys_file',
                                'uid_local' => $file->getUid(),
                                'tablenames' => 'tx_mymap_domain_model_location',
                                'uid_foreign' => $imageObject['uid'],
                                'fieldname' => 'image',
                                'pid' => $imageObject['pid']
                            ];
                            // Get an instance of the DataHandler and process the data
                            /** @var DataHandler $dataHandler */
                            $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
                            $dataHandler->start($data, []);
                            $dataHandler->process_datamap();
							$migratedImages++;
							$oldImageField = 1;
                        }
                    } catch (\Exception $e) {
                        // file does not exists or whatever
                    }
                    // remove old image
                    $connection = $this->getConnectionPool()->getConnectionForTable('tx_mymap_domain_model_location');

					if($oldImageField) {
						$connection->update(
							'tx_mymap_domain_model_location',
							[
								'image' => $oldImageField
	
							],
							[
								'uid' => (int)$imageObject['uid']
							]
						);
					}
                }
                $this->messageArray[] = [
                    FlashMessage::OK,
                    'Migration successful',
                    sprintf(
                        'We have migrated %d images to FAL',
                        $migratedImages
                    )
                ];
            }
        }
    }


    /**
     * Migrate media field to FAL
     */
    protected function migrateMediaFieldToFal()
    {
        // check for old image column in tx_mymap_domain_model_location first
        $fields = DatabaseUtility::getColumnsFromTable('tx_mymap_domain_model_location');
        if (array_key_exists('media', $fields)) {
            $queryBuilder = $this->getConnectionPool()->getQueryBuilderForTable('tx_mymap_domain_model_location');
            $queryBuilder->getRestrictions()->removeAll()->add(
                GeneralUtility::makeInstance(DeletedRestriction::class)
            );
            $mediaArray = $queryBuilder
                ->select('uid', 'pid', 'media')
                ->from('tx_mymap_domain_model_location')
                ->where(
                    $queryBuilder->expr()->neq(
                        'media',
                        $queryBuilder->createNamedParameter('', \PDO::PARAM_STR)
                    )
                )
                ->execute()
                ->fetchAll();
			$migratedMedia = 0;

            if (is_array($mediaArray)) {
                foreach ($mediaArray as $mediaObject) {
                    try {
						$oldMediaField = 0;
                        /** @var File $file */
                        $file = ResourceFactory::getInstance()->retrieveFileOrFolderObject('uploads/tx_mymap/media/' . $mediaObject['media']);
                        if ($file instanceof FileInterface) {
                            // Assemble DataHandler data
                            $newId = 'NEW1234';
                            $data = [];
                            $data['sys_file_reference'][$newId] = [
                                'table_local' => 'sys_file',
                                'uid_local' => $file->getUid(),
                                'tablenames' => 'tx_mymap_domain_model_location',
                                'uid_foreign' => $mediaObject['uid'],
                                'fieldname' => 'media',
                                'pid' => $mediaObject['pid']
                            ];
                            // Get an instance of the DataHandler and process the data
                            /** @var DataHandler $dataHandler */
                            $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
                            $dataHandler->start($data, []);
                            $dataHandler->process_datamap();
							$migratedMedia++;
							$oldMediaField = 1;
                        }
                    } catch (\Exception $e) {
                        // file does not exists or whatever
                    }
                    // remove old media
                    $connection = $this->getConnectionPool()->getConnectionForTable('tx_mymap_domain_model_location');

					if($oldMediaField) {
						$connection->update(
							'tx_mymap_domain_model_location',
							[
								'media' => $oldMediaField
							],
							[
								'uid' => (int)$mediaObject['uid']
							]
						);
					}

                }
                $this->messageArray[] = [
                    FlashMessage::OK,
                    'Migration successful',
                    sprintf(
                        'We have migrated %d media to FAL',
                        $migratedMedia
                    )
                ];
            }
        }
    }



    /**
     * Generates output by using flash messages
     *
     * @return string
     */
    protected function generateOutput()
    {
        $output = '';
        foreach ($this->messageArray as $messageItem) {
            /** @var \TYPO3\CMS\Core\Messaging\FlashMessage $flashMessage */
            $flashMessage = GeneralUtility::makeInstance(
                FlashMessage::class,
                $messageItem[2],
                $messageItem[1],
                $messageItem[0]);

            if (version_compare(TYPO3_branch, '8.6') >= 0) {
                $output .= GeneralUtility::makeInstance(FlashMessageRendererResolver::class)
                    ->resolve()
                    ->render([$flashMessage]);
            } elseif (version_compare(TYPO3_branch, '8.0') >= 0) {
                $output .= $flashMessage->getMessageAsMarkup();
            } else {
                $output .= $flashMessage->render();
            }
        }
        return $output;
    }

    /**
     * Get TYPO3s Connection Pool
     *
     * @return ConnectionPool
     */
    protected function getConnectionPool()
    {
        return GeneralUtility::makeInstance(ConnectionPool::class);
    }

}
