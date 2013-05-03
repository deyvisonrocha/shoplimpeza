<?php

class ManagerController extends CoreController
{
	
	public function preDispatch()
	{
		parent::preDispatch();
		
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('login', 'json')
                    ->initContext();
	}
	
	public function init()
	{
		parent::init();
		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		
		$session_user = $this->getSessionUser();
		
		if (empty($session_user)) {
			$this->_helper->layout->setLayout('manager-login');
		}
		else {
			$this->_helper->layout->setLayout('manager');
		}
	}
	
	public function indexAction()
	{
		
	}
	
	public function loginAction()
	{
		CoreController::clearSession();
		
		$flashMessages = array();
		$f = new Zend_Filter_StripTags();
		
		$user_login = $f->filter($this->_getParam('user_login'));
		$password = $f->filter($this->_getParam('password'));
		
		if (empty($user_login)) {
			$flashMessages['error'] = "Usuário não informado.";
			$this->_helper->flashMessenger->addMessage($flashMessages);
		}
		
		$userModel = new UserModel();
		
		$user = $userModel->getByLogin($user_login);
		
		if (!empty($user)) {
		
			$auth = Zend_Auth::getInstance();
			
			$db = Zend_Registry::get('db');
			$authAdapter = new Zend_Auth_Adapter_DbTable($db);
			$authAdapter->setTableName('users');
			$authAdapter->setIdentityColumn('user');
			$authAdapter->setCredentialColumn('password');
			
			$authAdapter->setIdentity($user_login);
			$authAdapter->setCredential($password);
			$authAdapter->setCredentialTreatment('MD5(?)');
			
			$auth = Zend_Auth::getInstance();
			
			$result = $auth->authenticate($authAdapter);
			
			if ($result->isValid()) {
				$data = $authAdapter->getResultRowObject(null, 'password');
				
				$auth->getStorage()->write($data);
				
				$user_namespace = new Zend_Session_Namespace('user');
				$userLogado = Zend_Auth::getInstance()->getIdentity();
				$user_namespace->session_user = $userLogado;
				
				//$this->_helper->json(array('result' => 'success', 'msg' => 'Você está sendo redirecionado!'));
			}
			else {
				Zend_Auth::getInstance()->clearIdentity();
				//$this->_helper->json(array('result' => 'error', 'msg' => 'Senha inválida.'));
				$flashMessages['error'] = "Senha inválida.";
				$this->_helper->flashMessenger->addMessage($flashMessages);
			}
		}
		else {
			//$this->_helper->json(array('result' => 'error', 'msg' => 'Usuário inválido.'));
			$flashMessages['error'] = "Usuário inválido.";
			$this->_helper->flashMessenger->addMessage($flashMessages);
		}
		
		$this->_redirect('manager/index');
	}
	
	public function logoutAction()
	{
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_helper->layout()->disableLayout();
		CoreController::clearSession();
		
		Zend_Auth::getInstance()->clearIdentity();
		
		$this->_redirect("/");
	}
	
	public function alterarSenhaAction()
	{
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			$password_old = $data['password_old'];
			$password_new = $data['password_new'];
			$password_new_again = $data['password_new_again'];
			
			if (empty($password_old)) {
				$flashMessages['error'] = "A senha antiga não foi digitada.";
				$this->_helper->flashMessenger->addMessage($flashMessages);
				$this->_redirect('manager/alterar-senha');
			}
			else if (empty($password_new)) {
				$flashMessages['error'] = "A nova senha não foi digitada.";
				$this->_helper->flashMessenger->addMessage($flashMessages);
				$this->_redirect('manager/alterar-senha');
			}
			
			if ($password_new != $password_new_again) {
				$flashMessages['error'] = "A senha digitada não confere.";
				$this->_helper->flashMessenger->addMessage($flashMessages);
				$this->_redirect('manager/alterar-senha');
			}
			
			$session_user = $this->getSessionUser();
			
			$session_user_id = $session_user->id;
			$session_user_login = $session_user->user;
			
			$userModel = new UserModel();
			
			$user = $userModel->getByLogin($session_user_login);
			
			if ($user['password'] == md5($password_old)) {
				$result = $userModel->changePassword($session_user_id, $password_new);
					
				if ($result > 0) {
					$flashMessages['success'] = "A senha foi alterada com sucesso!";
					$this->_helper->flashMessenger->addMessage($flashMessages);
				}
				else {
					$flashMessages['error'] = "Ocorreu algum problema ao tentar alterar a senha!";
					$this->_helper->flashMessenger->addMessage($flashMessages);
				}
				
				$this->_redirect('manager/alterar-senha');
			}
			
		}
	}
}
