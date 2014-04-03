<?php
include_once 'Soap/SoapUser.php';


class ProdService {
	private $authorized = false;
	
	
	/**
	 * 身份验证
	 * @param Object $soapUser： 包括两个属性email和passwor
	 */
	public function authorize($soapUser) {
		if ($soapUser->email = 'los@qq.com' && $soapUser->password == '10') {
			$this->authorized = true;
		}
	}
	
	
	/**
	 * product：批量设置产品的黑白名单
	 * @param array(int) $prodIds
	 * @param string $blackOrWhite：N or Y
	 */
	public function setProdsBlackOrWhiteByProdIds($prodIds, $blackOrWhite) {
		if ($this->authorized) {
//			$result = json_encode($prodIds) . ' : ' . $blackOrWhite;
			$result = 'ok';
			return $result;
		} else {
			return 'authorized err';
		}
	}
	
} //End: class ProdService