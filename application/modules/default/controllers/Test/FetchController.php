<?php
include_once 'UsrService.php';

class Test_FetchController extends Zend_Controller_Action {
	public function indexAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	}
	
	
	/**
	 * 测试fetchAll的返回值，返回数组
	 */
	public function getusrsAction() {
		$usrs = UsrService::getUsrs();
		var_dump($usrs);
		exit;
	}
	
	
	/**
	 * 测试fetchRow的返回值，返回数组
	 */
	public function getusrAction() {
		$email = 'linice@qq.com';
		$usr = UsrService::getUsrByEmail($email);
		var_dump($usr);
		exit;
	}
	
	
	/**
	 * 测试fetchOne的返回值，返回标量scalar
	 */
	public function getusrscntAction() {
		$usrsCnt = UsrService::getUsrsCnt();
		var_dump($usrsCnt);
		exit;
	}
	
	
}



