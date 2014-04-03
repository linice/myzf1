<?php
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap 
{
	protected function _initLayoutHelper() 
	{
		require_once 'LayoutLoader.php';
		$this->bootstrap('frontController'); 
		$layout = Zend_Controller_Action_HelperBroker::addHelper(new LayoutLoader()); 
	}
	
}
