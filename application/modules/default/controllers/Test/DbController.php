<?php
include_once 'UsrService.php';

class Test_DbController extends Zend_Controller_Action {
	public function indexAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$db = Zend_Registry::get('DB');
		$sql = "select * from user where id = 2";
		try {
			$result = $db->fetchAll($sql);
		} catch (Exception $e) {
			var_dump($e->getMessage());
		}
		var_dump($result);
		if (empty($result)) {
			echo 'empty';
		}
		
		if ($result == NULL) {
			echo 'null';
		}
			
//			if (count($result) != 1) {
//				throw new Exception('Invalid user field: 2');
//			}
//			var_dump($result[0]);
		
		if ($result == NULL) {
			echo 'null';
		}
	}
	
	
	/**
	 * 测试insert的返回值
	 */
	public function saveAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$usr = array('role_id' => 1, 'email' => 'linice01@163.com', 'passwd' => md5('10'), 'nickname' => 'linice01');
		UsrService::saveUsr($usr);
	}
	
	
	/**
	 * 测试update的返回值
	 */
	public function updateAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$usr = array('nickname' => 'linice012');
		UsrService::updateUsrById(2, $usr);
	}
	
	
	/**
	 * test
	 */
	public function testAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		UsrService::test();
	}
}



