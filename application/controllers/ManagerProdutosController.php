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
			// $description = $this->_getParam('description');
			$image = $this->_getParam('image');
			$main = $this->_getParam('main');
			$product_versions = $this->_getParam('product_versions');
			$product_characters = $this->_getParam('product_characters');
			
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
				'category_id' => $category_id, 'name' => $name, 'description_short' => $description_short, /*'description' => $description,*/ 'image' => $image, 'main' => $main
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
						$data['name'] = $product_version['name'];
						$data['fragrance'] = $product_version['fragrance'];
						$data['color'] = $product_version['color'];
						$data['dilution'] = $product_version['dilution'];
						$data['packing'] = $product_version['packing'];
						
						$produtosVersoesModel->add($data);
					}
				}
			}
			
			array_filter($product_characters);
			
			if (! empty($product_characters)) {
				
				$produtosCaracteristicasModel = new ProdutosCaracteristicasModel();
				
				foreach ($product_characters as $product_character) {
					$data = array();
					$data['product_id'] = $id;
					$data['description'] = $product_character;
					
					$produtosCaracteristicasModel->add($data);
				}
			}
			
			$flashMessages['success'] = "Produto adicionado com sucesso!";
		}
		catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " .
					 $e->getTraceAsString();
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
			// $description = $this->_getParam('description');
			$image = $this->_getParam('image');
			$main = $this->_getParam('main');
			$product_versions = $this->_getParam('product_versions');
			$product_characters = $this->_getParam('product_characters');
			
			$data = array(
				'id' => $id, 'category_id' => $category_id, 'name' => $name, 'description_short' => $description_short, /*'description' => $description,*/ 'image' => $image, 'main' => $main
			);
			
			$produtosModel = new ProdutosModel();
			
			$result = $produtosModel->edit($data, $id);
			
			$produtosVersoesModel = new ProdutosVersoesModel();
			
			if (! empty($product_versions)) {
				$product_versions_exists = $produtosVersoesModel->getAllByProduct(
						$id);
				
				$product_versions_new = array();
				
				foreach ($product_versions as $product_version) {
					$product_version = array_filter($product_version);
					
					if (! empty($product_version)) {
						$data = array();
						// $data['id'] = NULL;
						$data['product_id'] = $id;
						$data['name'] = $product_version['name'];
						$data['fragrance'] = $product_version['fragrance'];
						$data['color'] = $product_version['color'];
						$data['dilution'] = $product_version['dilution'];
						$data['packing'] = $product_version['packing'];
						
						$product_versions_new[] = $data;
					}
				}
				
				for ($i = 0; $i < count($product_versions_exists); $i ++) {
					$diff = array_diff($product_versions_new[$i], 
							$product_versions_exists[$i]);
					
					if (isset($diff) && key($diff) == 'id' && count($diff) === 1) {
						unset($diff);
					}
					else if (!empty($diff)) {
						$id = $product_versions_exists[$i]['id'];
						$produtosVersoesModel->edit($diff, $id);
					}
				}
			}
			else {
				$produtosVersoesModel->deleteAllByProduct($id);
			}
			
			$produtosCaracteristicasModel = new ProdutosCaracteristicasModel();
			
			if (! empty($product_characters)) {
				$product_characters_exists = $produtosCaracteristicasModel->getAllByProduct(
						$id);
				
				$product_characters_new = array();
				
				foreach ($product_characters as $product_character) {
					$data = array();
					$data['product_id'] = $id;
					$data['description'] = $product_character;
					
					$product_characters_new[] = $data;
				}
				
				for ($i = 0; $i < count($product_characters_exists); $i ++) {
					$diff = array_diff($product_characters_new[$i], 
							$product_characters_exists[$i]);
					
					if (isset($diff) && key($diff) == 'id' && count($diff) === 1) {
						unset($diff);
					}
					else if (!empty($diff)) {
						$id = $product_characters_exists[$i]['id'];
						$produtosCaracteristicasModel->edit($diff, $id);
					}
				}
			}
			else {
				$produtosCaracteristicasModel->deleteAllByProduct($id);
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
			$flashMessages['error'] = "Ocorreu um erro: " .
					 $e->getTraceAsString();
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
			$produtosCaracteristicasModel = new ProdutosCaracteristicasModel();
			
			$produto_versoes = $produtosVersoesModel->getAllByProduct($id);
			$produto_caracteristicas = $produtosCaracteristicasModel->getAllByProduct(
					$id);
			
			$this->view->assign('produto', $produto);
		}
		
		if (empty($produto_versoes)) {
			$produto_versoes = array(
				array(
				'name' => '', 'fragrance' => '', 'color' => '', 'dilution' => '', 'packing' => ''
			)
			);
		}
		
		if (empty($produto_caracteristicas)) {
			$produto_caracteristicas = array(
				array(
				'description' => ''
			)
			);
		}
		
		$categoriasModel = new CategoriasModel();
		
		$categorias_select = $categoriasModel->getAll();
		
		$this->view->assign('produto_caracteristicas', $produto_caracteristicas);
		$this->view->assign('produto_versoes', $produto_versoes);
		$this->view->assign('categorias_select', $categorias_select);
	}
}
