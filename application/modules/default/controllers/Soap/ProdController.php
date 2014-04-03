<?php
include_once 'Soap/ProdService.php';


class Soap_ProdController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    
    //设置product黑白名单
	public function prodAction() {
		ini_set("soap.wsdl_cache_enabled", 0);
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
//		$server = new SoapServer('http://www.centos.com.dev/wsdl/prod.wsdl', 
//			array('soap_version' => SOAP_1_2));
		$server = new SoapServer('http://www.gcentos.com.cn.dev/wsdl/prod.wsdl', 
			array('soap_version' => SOAP_1_2));
//		$server = new SoapServer(null, array('uri' => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite'));
		$server->setClass("ProdService");
		$server->handle();
	}
	
	
	public function testAction() {
		try {
			ini_set("soap.wsdl_cache_enabled", '0');
			$this->_helper->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(TRUE);
			
			$soapUser = new SoapVar(array('email' => 'los@qq.com', 'password' => '10'), SOAP_ENC_OBJECT);
			$header = new SoapHeader('http://www.gcentos.com.cn.dev/wsdl/prod.wsdl', 'authorize', $soapUser, true);   
			
			$client = new SoapClient('http://www.gcentos.com.cn.dev/wsdl/prod.wsdl');
//			$client = new SoapClient('http://www.gcentos.com.cn.dev/wsdl/prod.wsdl', 
//				array('soap_version' => SOAP_1_2, 'trace' => 1,'exceptions' => 1,'encoding' => 'UTF-8'));
	//		$client = new SoapClient(null, array(
	//			'location' => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite',
	//			'uri'      => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite'
	//		));
			$client->__setSoapHeaders(array($header));
//			$prodIds = array(1, 2, 3);
			$prodIds = '1,2';		
			$result = $client->setProdsBlackOrWhiteByProdIds($prodIds, 'B');
			var_dump($result);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	public function test2Action() {
		echo 'Hello world';
		exit;
	}

}

