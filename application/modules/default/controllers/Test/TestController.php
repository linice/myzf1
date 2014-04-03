<?php
class Test_TestController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }
    
    
    public function indexAction() {
//		$this->_helper->layout()->disableLayout();
//		$this->_helper->viewRenderer->setNoRender(TRUE);
		
//		error_log('test error_log in zf', 3, 'D:/CurrentWork/centos_error_log.txt');
		echo '<br />';
		$test_test = realpath(dirname(__FILE__));
		var_dump($test_test);
		echo '<br />';
		var_dump(APPLICATION_PATH);
		echo '<br />';
		var_dump(APPLICATION_ENV);
		echo '<br />';
		
		$session = new Zend_Session_Namespace('AUTH');
		
		echo 'locale: ' . $session->locale;
    }
    
    
    public function testAction() {
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		echo var_dump(__CLASS__);
    	echo '<br />';
    	echo var_dump(__FUNCTION__);
    	echo '<br />';
    	echo var_dump(__METHOD__);
    	echo '<br />';
    	
    	var_dump($_SESSION);
    	echo '<br />';
    	var_dump($_COOKIE);
    	echo '<br />';
    	var_dump(APPLICATION_ENV);
    }
    
    
    
}