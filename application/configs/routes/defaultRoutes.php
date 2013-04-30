<?php
$router = Zend_Registry::get('router');

/*$route = new Zend_Controller_Router_Route(
	'empresa/:method',
	array('module' => 'default', 'controller' => 'Api', 'action' => 'api')
);
$router->addRoute('DefaultRest', $route);*/

$route = new Zend_Controller_Router_Route(
		'/empresa',
		array('module' => 'default', 'controller' => 'Index', 'action' => 'empresa')
);
$router->addRoute('EmpresaRouter', $route);

?>