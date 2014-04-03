<?php
include_once 'Soap/SoapUser.php';


class SwService {
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
	 * $jsonProdIds为json_encode处理的数组得到的字符串
	 * @param unknown_type $jsonProdIds
	 * @param unknown_type $blackOrWhite
	 */
	public function setProdsBlackOrWhiteByJsonProdIds($jsonProdIds, $blackOrWhite) {
		if ($this->authorized) {
			$result = $jsonProdIds . ' : ' . $blackOrWhite;
			return $result;
		} else {
			return 'authorized err';
		}
	}
	
} //End: class SwService