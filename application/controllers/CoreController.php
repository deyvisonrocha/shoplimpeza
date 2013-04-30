<?php

class CoreController extends Zend_Controller_Action
{
	
	protected $_page_title = '';
	
	protected $_absolute_path = null;
	
	protected $_relative_path = null;
	
	protected $_public_path = null;
	
	protected $_absolute_url = null;
	
	protected $_css_url = null;
	
	protected $_js_url = null;
	
	public function init()
	{
		parent::init();
		
		$config = Zend_Registry::get("config");
		
		$this->_page_title = $config->configuration->default_title;
		
		$this->_relative_path = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
		
		$this->_absolute_path = $_SERVER['DOCUMENT_ROOT'] . $this->_relative_path;
		
		$this->_public_path = $this->_relative_path . '/public/';
		
		$http_host = $_SERVER['HTTP_HOST'];
		
		$this->_absolute_url = 'http://' . $http_host . $this->_relative_path;
		
		$this->_css_url = 'http://' . $http_host . $this->_public_path . 'css/';
		
		$this->_js_url = 'http://' . $http_host . $this->_public_path . 'js/';
		
		$this->view->assign('page_title', $this->_page_title);
		$this->view->assign('relative_path', $this->_relative_path);
		$this->view->assign('absolute_path', $this->_absolute_path);
		$this->view->assign('public_path', $this->_public_path);
		$this->view->assign('absolute_url', $this->_absolute_url);
		$this->view->assign('css_url', $this->_css_url);
		$this->view->assign('js_url', $this->_js_url);
	}
	
}