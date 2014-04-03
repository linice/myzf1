<?php
/**
 * soap service
 * @author los
 *
 */
class CalcService {
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
	 * service function: calc
	 * @param array(int) $x1
	 * @param string $x2
	 */
	public function getYByX($x1, $x2) {
		if ($this->authorized) {
//			$result = json_encode($prodIds) . ' : ' . $blackOrWhite;
			$y = 0;
			foreach ($x1 as $x) {
				$y += $x * $x2;
			}
			$result = $y;
			return $result;
		} else {
			return 'authorized err';
		}
	}
	
	
	
	public function test() {
		if ($this->authorized) {
			return 'Good';
		} else {
			return 'Bad';
		}
	}
	
} //End: class CalcService