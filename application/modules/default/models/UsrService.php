<?php
include_once 'LogService.php';

class UsrService
{
	/**
	 * usr: 保存
	 * @param array(field => value) $row
	 */
	public static function saveUsr($row = array()) {
		if (!is_array($row)) {
			return FALSE;
		}
		$db = Zend_Registry::get('DB');
		try {
//			$result = $db->insert('usr', $row);
//			var_dump($result);
			$db->insert('usr', $row);
		} catch (Exception $e) {
			$jsRow = json_encode($row);
			$log = array('level' => 3, 'msg' => "row: $jsRow, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return TRUE;
	}
	
	
	/**
	 * usr: 更新，条件：id
	 * @param int $id
	 * @param array(field => value) $row
	 */
	public static function updateUsrById($id = 0, $row = array()) {
		if (!is_numeric($id)) {
			return FALSE;
		}
		if (!is_array($row)) {
			return FALSE;
		}
		$db = Zend_Registry::get('DB');
		$where = $db->quoteInto('id = ?', $id);
		try {
//			$result = $db->update('usr', $row, $where);
//			var_dump($result);
			$db->update('usr', $row, $where);
		} catch (Exception $e) {
			$jsRow = json_encode($row);
			$log = array('level' => 3, 'msg' => "row: $jsRow, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return TRUE;
	}
	
	
	/**
	 * usr: 查询 
	 * @param string $email
	 * @param array(field => value) $fields
	 */
	public static function getUsrByEmail($email, $fields = array('*')) {
		if (empty($email)) {
			return FALSE;
		}
		if (!is_array($fields)) {
			return FALSE;
		}
		$db = Zend_Registry::get('DB');
		$strFields = implode(',', $fields);
		$email = addslashes($email);
		$sql = "select $strFields from usr where email = '$email'";
		try {
			$result = $db->fetchRow($sql);
		} catch (Exception $e) {
			$log = array('level' => 3, 'msg' => "email: $email, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return $result;
	}
	
	
	/**
	 * usr: 查询
	 * @param array(field => value) $fields
	 */
	public static function getUsrs($fields = array('*')) {
		if (!is_array($fields)) {
			return FALSE;
		}
		$db = Zend_Registry::get('DB');
		$strFields = implode(',', $fields);
		$sql = "select $strFields from usr";
		try {
			$result = $db->fetchAll($sql);
		} catch (Exception $e) {
			$log = array('level' => 3, 'msg' => "{$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return $result;
	}
	
	
	/**
	 * usr: 查询，数量
	 * @param array(field => value) $fields
	 */
	public static function getUsrsCnt() {
		$db = Zend_Registry::get('DB');
		$sql = "select count(*) as cnt from usr";
//		$sql = "select email from usr";
		try {
			$result = $db->fetchOne($sql);
		} catch (Exception $e) {
			$log = array('level' => 3, 'msg' => "{$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return $result;
	}
	
	
	
	/**
	 * test: 测试insert的返回值
	 * @param array(field => value) $row
	 */
	public static function test() {
		$db = Zend_Registry::get('DB');
		$sql = "insert usr(role_id, email, passwd, nickname)
			values (2, 'jing@qq.com', md5('10'), 'jing' ),
				(2, 'linice@qq.com', md5('10'), 'linice' )";
		try {
			$result = $db->query($sql);
			var_dump($result);
		} catch (Exception $e) {
			$jsRow = json_encode($row);
			$log = array('level' => 3, 'msg' => "row: $jsRow, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return TRUE;
	}
	
	
	
} //End: class EmailModel extends Zend_Mail_Storage_Imap
