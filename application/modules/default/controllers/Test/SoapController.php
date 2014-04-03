<?php
include_once 'UsrService.php';

class Test_SoapController extends Zend_Controller_Action {
	/**
	 * Client：测试盘点
	 */
	public function clientAction() {
		try {
			ini_set("soap.wsdl_cache_enabled", '0');
			
			$auth = new SoapVar(array('user' => 'cff_client', 'password' => 'cff@stk25'), SOAP_ENC_OBJECT);
//			$header = new SoapHeader('http://xlj.istore.com/wsdl/inventory.wsdl', 'authorize', $auth, true);   
//			$client = new SoapClient('http://xlj.istore.com/wsdl/inventory.wsdl');
			$header = new SoapHeader('http://121.15.134.94:8686/wsdl/inventory.wsdl', 'authorize', $auth, true);   
			$client = new SoapClient('http://121.15.134.94:8686/wsdl/inventory.wsdl');
			$client->__setSoapHeaders(array($header));
			$result = $client->test();
			$product_id = '10011325';
			$cff_quantity = 34;
			$onHold_quantity = 4;
			$inventroy_orders = 'testing soap of cff';
			$waitShelfQuantity = 2;
			$exRsn = '丢失';
			$result2 = $client->updateStockByCff($product_id, $cff_quantity, $onHold_quantity, $inventroy_orders, $waitShelfQuantity, $exRsn);
			var_dump($result);
			echo '<br />';
			var_dump($result2);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		exit;
	}
}



