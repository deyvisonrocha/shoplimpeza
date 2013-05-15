<?php
class ProdutosController extends CoreController
{
	
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		$category = $this->_getParam('category');
		$product = $this->_getParam('product');
		
		$categoriasModel = new CategoriasModel();
		$categorias = $categoriasModel->listAll();
			
		$produtosModel = new ProdutosModel();
		$produtos = $produtosModel->listAll();
			
		$this->view->assign('categorias', $categorias);
		$this->view->assign('produtos', $produtos);
		
		if ($category != ':category') {
			
		}
		
	}
}
