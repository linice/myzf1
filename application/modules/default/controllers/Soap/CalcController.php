<?php
include_once 'Soap/CalcService.php';

/**
 * Soap Server & Client
 * @author los
 *
 */
class Soap_CalcController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    
    /**
     * soap server
     */
	public function calcAction() {
		ini_set("soap.wsdl_cache_enabled", 0);
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
//		$server = new SoapServer('http://www.centos.com.dev/wsdl/calc.wsdl', 
//			array('soap_version' => SOAP_1_2));
		$server = new SoapServer('http://www.gcentos.com.cn.dev/wsdl/calc.wsdl', 
			array('soap_version' => SOAP_1_2));
//		$server = new SoapServer(null, array('uri' => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite'));
		$server->setClass("CalcService");
		$server->handle();
	}
	
	
	/**
	 * soap client drive
	 */
	public function testAction() {
		try {
			ini_set("soap.wsdl_cache_enabled", '0');
			$this->_helper->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(TRUE);
			
			$soapUser = new SoapVar(array('email' => 'los@qq.com', 'password' => '10'), SOAP_ENC_OBJECT);
			$header = new SoapHeader('http://www.gcentos.com.cn.dev/wsdl/calc.wsdl', 'authorize', $soapUser, true);   
			
			$client = new SoapClient('http://www.gcentos.com.cn.dev/wsdl/calc.wsdl');
//			$client = new SoapClient('http://www.gcentos.com.cn.dev/wsdl/calc.wsdl', 
//				array('soap_version' => SOAP_1_2, 'trace' => 1,'exceptions' => 1,'encoding' => 'UTF-8'));
	//		$client = new SoapClient(null, array(
	//			'location' => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite',
	//			'uri'      => 'http://www.gcentos.com.cn.dev/soap_sw/setprodsblackorwhite'
	//		));
			$client->__setSoapHeaders(array($header));
//			$prodIds = array(1, 2, 3);
			$prodIds = array(2, 3);		
			$result = $client->getYByX($prodIds, 4);
			$result2 = $client->test();
			var_dump($result);
			echo '<br />';
			var_dump($result2);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	/**
	 * other
	 */
	public function test2Action() {
		echo 'Hello world';
		exit;
	}

}

