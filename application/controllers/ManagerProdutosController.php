<?php

class ManagerProdutosController extends ManagerController
{

	public function init ()
	{
		parent::init();
	}

	public function indexAction ()
	{
		$order_by = $this->_getParam('order_by');
		$order_name = $this->_getParam('order_name');
		
		$produtosModel = new ProdutosModel();
		
		$filters = array();
		
		$produtos = $produtosModel->listAll($filters);
		
		$this->view->assign('produtos', $produtos);
	}

	public function addAction ()
	{
		try {
			$name = $this->_getParam('name');
			$category_id = $this->_getParam('category_id');
			$description_short = $this->_getParam('description_short');
			$description = $this->_getParam('description');
			$image = $this->_getParam('image');
			$main = $this->_getParam('main');
			$product_versions = $this->_getParam('product_versions');
			
			if (empty($category_id)) {
				$flashMessages['error'] = 'A Categoria deve ser informada!';
			}
			
			if (empty($name)) {
				$flashMessages['error'] = 'O nome deve ser informado!';
			}
			
			if (! empty($flashMessages)) {
				$this->_helper->flashMessenger->addMessage($flashMessages);
				$this->_redirect('manager/produtos/form');
			}
			
			$data = array(
				'category_id' => $category_id,
				'name' => $name,
				'description_short' => $description_short,
				'description' => $description,
				'image' => $image,
				'main' => $main
			);
			
			$produtosModel = new ProdutosModel();
			
			$id = $produtosModel->add($data);
			
			if (! empty($product_versions)) {
				
				$produtosVersoesModel = new ProdutosVersoesModel();
				
				foreach ($product_versions as $product_version) {
					
					$product_version = array_filter($product_version);
					
					if (! empty($product_version)) {
						$data = array();
						$data['product_id'] = $id;
						$data['name'] = $product_version['pv_name'];
						$data['fragrance'] = $product_version['pv_fragrance'];
						$data['color'] = $product_version['pv_color'];
						$data['dilution'] = $product_version['pv_dilution'];
						$data['packing'] = $product_version['pv_packing'];
						
						$produtosVersoesModel->add($data);
					}
				}
			}
			
			$flashMessages['success'] = "Produto adicionado com sucesso!";
		}
		catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getTraceAsString();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/produtos/index');
	}

	public function editAction ()
	{
		try {
			$id = $this->_getParam('product_id');
			$category_id = $this->_getParam('category_id');
			$name = $this->_getParam('name');
			$description_short = $this->_getParam('description_short');
			$description = $this->_getParam('description');
			$image = $this->_getParam('image');
			$main = $this->_getParam('main');
			$product_versions = $this->_getParam('product_versions');
			
			$data = array(
				'id' => $id,
				'category_id' => $category_id,
				'name' => $name,
				'description_short' => $description_short,
				'description' => $description,
				'image' => $image,
				'main' => $main
			);
			
			$produtosModel = new ProdutosModel();
			
			$result = $produtosModel->edit($data, $id);
			
			$produtosVersoesModel = new ProdutosVersoesModel();
			
			if (! empty($product_versions)) {
				$product_versions_exists = $produtosVersoesModel->getAllByProduct($id);
				
				foreach ($product_versions as $product_version) {
					$product_version = array_filter($product_version);
					
					if (! empty($product_version)) {
						$data = array();
						$data['product_id'] = $id;
						$data['name'] = $product_version['pv_name'];
						$data['fragrance'] = $product_version['pv_fragrance'];
						$data['color'] = $product_version['pv_color'];
						$data['dilution'] = $product_version['pv_dilution'];
						$data['packing'] = $product_version['pv_packing'];
						
						if ($product_versions_exists) {}
						
						$produtosVersoesModel->edit($data);
					}
				}
			}
			else {
				$produtosVersoesModel->deleteAllByProduct($id);
			}
			
			$flashMessages['success'] = "Produto editado com sucesso!";
		}
		catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getMessage();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/produtos/index');
	}

	public function deleteAction ()
	{
		try {
			$id = $this->_getParam('id');
			
			$produtosModel = new ProdutosModel();
			
			$result = $produtosModel->delete($id);
			
			$flashMessages['success'] = "Produto deletado com sucesso!";
		}
		catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getTraceAsString();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/produtos/index');
	}

	public function formAction ()
	{
		$produtosModel = new ProdutosModel();
		
		$id = (int) $this->_getParam('id');
		
		if (! empty($id)) {
			$produto = $produtosModel->get($id);
			$produtosVersoesModel = new ProdutosVersoesModel();
			
			$produto_versoes = $produtosVersoesModel->getAllByProduct($id);
			
			$this->view->assign('produto', $produto);
		}
		
		if (empty($produto_versoes)) {
			$produto_versoes = array(
				array(
					'pv_name' => '',
					'pv_fragrance' => '',
					'pv_color' => '',
					'pv_dilution' => '',
					'pv_packing' => ''
				)
			);
		}
		
		$categoriasModel = new CategoriasModel();
		
		$categorias_select = $categoriasModel->getAll();
		
		$this->view->assign('produto_versoes', $produto_versoes);
		$this->view->assign('categorias_select', $categorias_select);
	}
}
