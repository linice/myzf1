<?php
include_once 'LogService.php';

class AuthService {
	//登陆验证，返回值用于写session
	public static function authenticate($email=null, $passwd=null, $fields=array('*')) {
		try {
			$db = Zend_Registry::get('DB');
			$strFields = implode(',', $fields);
			$email = addslashes($email);
			$passwd = md5($passwd);
			$sql = "select $strFields from usr
				where email = '$email'
					and passwd = '$passwd'";
			$result = $db->fetchAll($sql);
			if (count($result) == 1) {
				return $result[0];
			}
		} catch (Exception $e) {
			$log = array('level' => 3, 'msg' => "email: $email, passwd: $passwd, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return FALSE;
	}
	
	
}
