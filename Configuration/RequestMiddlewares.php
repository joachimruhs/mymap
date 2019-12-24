<?php


return [
    'frontend' => [
        'typo3/cms-frontend/eid' => [
            'disabled' => false,
        ],		
        'wsr/mymap/map-utilities' => [
			'disabled' => false,
            'target' => \WSR\Mymap\Middleware\MapUtilities::class,
            'before' => [
//				'typo3/cms-frontend/authentication'
				'typo3/cms-frontend/shortcut-and-mountpoint-redirect'

				
            ],
            'after' => [
//				'typo3/cms-frontend/tsfe'
            ],
        ],
    ]
];

