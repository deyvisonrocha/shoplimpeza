<?php
// Define session name para a aplicação
session_name("SHOPLIMPEZA");

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', 
	(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : (($_SERVER['SERVER_NAME'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') ? 'development' : 'production')));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/classes'),
    realpath(APPLICATION_PATH . '/controllers'),
    realpath(APPLICATION_PATH . '/models'),
    get_include_path(),
)));

$http_host = $_SERVER['HTTP_HOST'];

if (APPLICATION_ENV == 'production') {
	
}
else if (APPLICATION_ENV == 'development' || APPLICATION_ENV == 'testing') {
	
}

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');

$autoloader = $application->getAutoloader();

$autoloader->setFallbackAutoloader(true)->suppressNotFoundWarnings(false);

$application->bootstrap()->run();
