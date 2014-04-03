<?php
include_once 'Util/TableService.php';

class Test_TableController extends Zend_Controller_Action {
	public function indexAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$result = TableService::genTableInsSql('role', array('code', 'name'));
		var_dump($result);
	}
	
	
	
} //End: class Test_TableController