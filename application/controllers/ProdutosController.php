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
		
		$category = ($category == ':category' ? null : $category);
		$product = ($product == ':product' ? null : $product);
		$id = ($id == ':id' ? null : $id);
		
		$filtersCategory = array();
		
		$categoriasModel = new CategoriasModel();
		$categorias = $categoriasModel->listAll($filtersCategory);
			
		$produtosModel = new ProdutosModel();
		
		$filtersProduct = array();
		
		if (!empty($category) && empty($product)) {
			$filtersProduct['main'] = 1;
			$filtersProduct['category_name'] = $category;
		}
		
		$produtos = $produtosModel->listAll($filtersProduct);
		
		if (!empty($produtos)) {
			$id = $produtos[0]['id'];
		}
		
		$produtosVersoesModel = new ProdutosVersoesModel();
		
		$produtosCaracteristicasModel = new ProdutosCaracteristicasModel();
		
		$this->view->assign('categorias', $categorias);
		$this->view->assign('produtos', $produtos);
		
		if ($category != ':category' || $product != ':product' || $id != ':id') {
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
