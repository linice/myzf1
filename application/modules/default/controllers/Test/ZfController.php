<?php
include_once 'auth/AuthModel.php';
class Test_ZfController extends Zend_Controller_Action 
{
	function init() {
//		$this->view->baseUrl = $this->_request->getBaseUrl();
	}
	
	
	function indexAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$usr = AuthModel::getUsrByEmail();
		var_dump($usr);
	}
	
	
	function handletestAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		$param = $this->_getParam('paramName');
		var_dump($param);
	}
}