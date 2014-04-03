<?php
class IndexController extends Zend_Controller_Action
{
     public function init()
    {
//    	require_once 'acl/permission.php';
        /* Initialize action controller here */
//		include_once 'Admin_UtilHelper.php';
//		getAndSaveResources();
//		$db = Zend_Registry::get('DB');
////		$controller = get_class();
//		$actions = get_class_methods(__CLASS__);
//		var_dump(__CLASS__);
//		var_dump($actions);
    }

    public function indexAction()
    {
        $layout = Zend_Registry::get('LAYOUT');
        $layout->navUris = array('/');
        $layout->navNames = array('Homepage');
        var_dump($layout->navNames);
        $layout->headTitle('CentOS ZF in index');
//        $this->view->show = 'Zend Framework training course in www.zend.vn<br>Front-End';
        $this->view->show = 'username3 default index';
//        $this->_redirect();
		$module = $this->_request->getModuleName();
		$controller = $this->_request->getControllerName();
		$action = $this->_request->getActionName();
		$uri = $this->_request->getRequestUri();
		var_dump(array($module, $controller, $action, $uri));
    }
    
    
    public function soapAction() {
    	// load Zend libraries
//		require_once 'Zend/Loader.php';
//		Zend_Loader::loadClass('Zend_Soap_Client');
		
		// initialize SOAP client
		$options = array(
			'location' => 'http://www.centos.com.cn.dev:8000/soap_soapserver/index',
			'uri'      => 'http://www.centos.com.cn.dev:8000/soap_soapserver/index'
		);
		
		try {
//    		ini_set("soap.wsdl_cache_enabled", 0);
			$client = new Zend_Soap_Client(null, $options);
			$result = $client->hello();
			var_dump($result);
		} catch (SoapFault $f) {
			die('ERROR： Soap Fault: [' . $f->faultcode . '] ' . $f->faultstring);
		} catch (Exception $e) {
			die('ERROR: Soap Exception：' . $e->getMessage());
		}
    }

    

	public function wsdlAction() {
//    	$fc = Zend_Controller_Front::getInstance();
//    	$fc->setParam('noViewRenderer', true);
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		try {
//    		ini_set("soap.wsdl_cache_enabled", 0);
			$client = new Zend_Soap_Client('http://www.centos.com.cn.dev:8000/soap_soapserver/wsdl');
			$result = $client->hello();
			var_dump($result);
		} catch (SoapFault $f) {
			die('ERROR： Soap Fault: [' . $f->faultcode . '] ' . $f->faultstring);
		} catch (Exception $e) {
			die('ERROR: Soap Exception：' . $e->getMessage());
		}
    }
    
    

    

}