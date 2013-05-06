<?php
class ManagerCategoriasController extends ManagerController
{
	
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		$order_by = $this->_getParam('order_by');
		$order_name = $this->_getParam('order_name');
		
		$categoriasModel = new CategoriasModel();
		
		$filters = array();
		
		$categorias = $categoriasModel->listAll($filters);
		
		$this->view->assign('categorias', $categorias);
	}
	
	public function addAction()
	{
		try {
			$name = $this->_getParam('name');
			$parent_id = $this->_getParam('parent_id', 0);
			
			$data = array('name' => $name, 'parent_id' => $parent_id);
			
			$categoriasModel = new CategoriasModel();
			
			$id = $categoriasModel->add($data);
			
			$flashMessages['success'] = "Categoria adicionada com sucesso!";
		} catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getTraceAsString();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/categorias/index');
	}
	
	public function editAction()
	{
		try {
			$id = $this->_getParam('categoria_id');
			$name = $this->_getParam('name');
			$parent_id = $this->_getParam('parent_id', 0);
				
			$data = array('name' => $name, 'parent_id' => $parent_id);
				
			$categoriasModel = new CategoriasModel();
			
			$result = $categoriasModel->edit($data, $id);
				
			$flashMessages['success'] = "Categoria editada com sucesso!";
		} catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getTraceAsString();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/categorias/index');
	}
	
	public function deleteAction()
	{
		try {
			$id = $this->_getParam('id');
		
			$categoriasModel = new CategoriasModel();
		
			$result = $categoriasModel->delete($id);
		
			$flashMessages['success'] = "Categoria deletada com sucesso!";
		} catch (Zend_Exception $e) {
			$flashMessages['error'] = "Ocorreu um erro: " . $e->getTraceAsString();
		}
		
		$this->_helper->flashMessenger->addMessage($flashMessages);
		$this->_redirect('manager/categorias/index');
	}
	
	public function formAction()
	{
		$categoriasModel = new CategoriasModel();
		
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			$id = $data['id'];

			if (!empty($id)) {
				$result = $categoriasModel->edit($data, $id);
				$flashMessages['success'] = "Categoria editada com sucesso!";
				$this->_helper->flashMessenger->addMessage($flashMessages);
			}
			else {
				$result = $categoriasModel->add($data);
				$flashMessages['success'] = "Categoria adicionada com sucesso!";
				$this->_helper->flashMessenger->addMessage($flashMessages);
			}
			
			$this->_redirect('manager/categorias/index');
		}
		
		$id = $this->_getParam('id');
		
		
		if (!empty($id)) {
			$categoria = $categoriasModel->get($id);
			
			$this->view->assign('categoria', $categoria);
		}
		
		$categorias_select = $categoriasModel->getAll();
		
		$this->view->assign('categorias_select', $categorias_select);
		
	}
	
}