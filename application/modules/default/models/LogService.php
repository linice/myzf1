<?php
class LogService
{

	public static function saveLog($row = array()) {
		if (!is_array($row)) {
			error_log(date('Y-m-d H:i:s') . "\t saveLog: Param is not a row. \n", 3, APPLICATION_PATH . '/../public/log/istore2.log');
			return false;
		}
		$db = Zend_Registry::get('DB');
		try{
			$db->insert('logs', $row);
		} catch (Exception $e) {
			$strRow = json_encode($row);
			error_log(date('Y-m-d H:i:s') . "\t saveLog: row = $strRow, {$e->getMessage()} \n", 3, APPLICATION_PATH . '/../public/log/istore2.log');
			return false;
		}
		return true;
	}
}