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
		$id = $this->_getParam('id');
		
		$categoriasModel = new CategoriasModel();
		$categorias = $categoriasModel->listAll();
			
		$produtosModel = new ProdutosModel();
		$produtos = $produtosModel->listAll();
		
		$produtosVersoesModel = new ProdutosVersoesModel();
		
		$produtosCaracteristicasModel = new ProdutosCaracteristicasModel();
		
		$this->view->assign('categorias', $categorias);
		$this->view->assign('produtos', $produtos);
		
		if ($category != ':category' && $product != ':product' && $id != ':id') {
			$produto = $produtosModel->get($id);
			
			$produto_versoes = $produtosVersoesModel->getAllByProduct($id);
			$produto['versoes'] = $produto_versoes;
			
			$produto_caracteristicas = $produtosCaracteristicasModel->getAllByProduct($id);
			$produto['caracteristicas'] = $produto_caracteristicas;
		}
		else {
			$produto = $produtosModel->getMain();
			
			$produto_versoes = $produtosVersoesModel->getAllByProduct($produto['id']);
			$produto['versoes'] = $produto_versoes;
			
			$produto_caracteristicas = $produtosCaracteristicasModel->getAllByProduct($id);
			$produto['caracteristicas'] = $produto_caracteristicas;
		}
		
		$category_id = $produto['category_id'];
			
		$categoria_nome = $categoriasModel->get($category_id);
		$produto['categoria'] = $categoria_nome['name'];
		
		$this->view->assign('produto', $produto);
	}
}
