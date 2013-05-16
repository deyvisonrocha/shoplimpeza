<?php
$router = Zend_Registry::get('router');

/*$route = new Zend_Controller_Router_Route(
	'empresa/:method',
	array('module' => 'default', 'controller' => 'Api', 'action' => 'api')
);
$router->addRoute('DefaultRest', $route);*/

$route = new Zend_Controller_Router_Route(
		'/empresa',
		array('module' => 'default', 'controller' => 'index', 'action' => 'empresa')
);
$router->addRoute('EmpresaRouter', $route);

$route = new Zend_Controller_Router_Route(
		'/contato',
		array('module' => 'default', 'controller' => 'index', 'action' => 'contato')
);
$router->addRoute('ContatoRouter', $route);

$route = new Zend_Controller_Router_Route(
		'/produtos/:category/:product/:id',
		array('module' => 'default', 'controller' => 'produtos', 'action' => 'index', 'category' => ':category', 'product' => ':product', 'id' => ':id')
);
$router->addRoute('ProdutosRouter', $route);


/**
 * Área Administrativa
 */
$route = new Zend_Controller_Router_Route(
		'/manager/produtos/:action/:id',
		array('module' => 'default', 'controller' => 'manager-produtos', 'action' => ':action', 'id' => ':id')
);
$router->addRoute('ManagerProdutosRouter', $route);

$route = new Zend_Controller_Router_Route(
		'/manager/categorias/:action/:id',
		array('module' => 'default', 'controller' => 'manager-categorias', 'action' => ':action', 'id' => ':id')
);
$router->addRoute('ManagerCategoriasRouter', $route);

?>