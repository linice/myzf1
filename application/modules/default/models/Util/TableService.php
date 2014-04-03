<?php
include_once 'LogService.php';

class TableService {
	/**
	 * 通过表名，将表中的数据生成insert sql
	 * @param string $table
	 * @param array(string) $fields
	 */	
	public static function genTableInsSql($table, $fields = array('*')) {
		if (!is_string($table)) {
			return false;
		}
		if (!is_array($fields)) {
			return false;
		}
		$table = addslashes($table);
		$rows = self::getTableAllRows($table, $fields);
		if ($fields == array('*')) {
			$sql = "insert $table values ";
		} else {
			$strFields = implode(',', $fields);
			$sql = "insert $table($strFields) values ";
		}
		
		foreach ($rows as $row) {
			$sql .= "('" . implode("','", $row) . "'),";
		}
		$sql = rtrim($sql, ', ');
		return $sql;
	}
	
	
	/**
	 * 查询给定表中，指定字段的所有数据
	 * @param string $table
	 * @param array(string) $fields
	 */
	public static function getTableAllRows($table, $fields = array('*')) {
		if (!is_string($table)) {
			return false;
		}
		if (!is_array($fields)) {
			return false;
		}
		$db = Zend_Registry::get('DB');
		$table = addslashes($table);
		$strFields = implode(',', $fields);
		$sql = "select $strFields from $table";
		try {
			$result = $db->fetchAll($sql);
		} catch (Exception $e) {
			$log = array('level' => 3, 'msg' => "sql: $sql, {$e->getMessage()}", 'class' => __CLASS__, 'func' => __FUNCTION__);
			LogService::saveLog($log);
			return FALSE;
		}
		return $result;
	}
	
	
	
	
} //End: class TableService