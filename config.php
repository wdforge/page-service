<?php

/**
 * 
 * @package    Pages
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */

include ROOT_SERVER_CONFIG;
include ROOT_SERVICES_CONFIG;


return [

    // фаил лога
    'logfiles' => [
         'pages'=>dirname(__FILE__) . '/log/log_' . date('Y-m-d_H') . '.log',
	],

    // пути для автозагрузки классов
    'autoload_paths' => [
        // локальные пути сервиса
        realpath(dirname(__FILE__) . '/src/'),
    ],

    // 1 сервис = 1 шаблон

    'layout' => [
    	'pages'=> [             
			'path' => dirname(__FILE__) . '/views/',
            'charset' => 'UTF-8',
            'scripts' => [
                  '/pages/js/test1.js',
                  '/pages/js/test2.js',    	
            ],

            'styles'  => [
	              '/pages/css/test1.css',
    	          '/pages/css/test2.css',
            ],                         
        ],
    ],

    'partials' => [
		'pages'=>[
			'blocks'=>[
                'template1'=> dirname(__FILE__) . '/views/partition/template1.phtml',
			],
		],
	],

    // роутинг сразу на заданный контроллер
    //'primary_controller' => 'Pages_Controller',
    // настройка для инициализации репозитория и его получение через ServiceManager
    'repositories' => [
        '\PagesService\Entity\Page\EntityPageItem' => [
            'class' => 'PagesService\Pages\PagesRepository',
        ],

        'Entity_Section_Item' => [
            'class' => 'SectionsRepository',
        ],

        'Entity_Block_Item' => [
            'class' => 'BlocksRepository',
        ],

    ],
    'connection' => [
        'pages' => [
            'db' => $dbPdo
        ],
    ],

	'access-manager'=> null,
];
