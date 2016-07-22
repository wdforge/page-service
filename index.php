<?php

/**
 * 
 * @package    System
 * @author     Dolgii Yurii <wdforge@gmail.com>
 * @version    1.0
 */
date_default_timezone_set('America/Los_Angeles');

// серверные и сервисные рутовые конфиги
define('SERVICE_DIRECTORY', dirname(__FILE__));
define('ROOT_SERVER_CONFIG', SERVICE_DIRECTORY. '/../../server.cfg.php');
define('ROOT_SERVICES_CONFIG', SERVICE_DIRECTORY . '/../../services.cfg.php');
 
// контейнер сервиса
chdir(dirname(__DIR__).'/../../');

require('vendor/autoload.php');
use System\Service\Container;

$container = new Container(
	'Pages', [
	    ROOT_SERVER_CONFIG,
    	ROOT_SERVICES_CONFIG,		
        SERVICE_DIRECTORY. '/config.php',
	]
);

$container->run();

