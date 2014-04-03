<?php
class IndexService {
	public static function searchAndSaveResources($moduleDir) {
        echo "$moduleDir<br>";
		if(is_dir($moduleDir)){
			$dp = dir($moduleDir);
			while($file = $dp->read()) {
				if($file!='.' && $file!='..')
					self::searchAndSaveResources($moduleDir.'/'.$file);
			}
			$dp->close();
		}
	}
	
	
	/**
	 * 保存资源
	 * @param string $module
	 * @param string $controller
	 * @param string $action
	 */
	public static function saveResource($module=null, $controller=null, $action=null) {
		$db = Zend_Registry::get('DB');
		$sql = 'insert resources(module, controller, action) values(?, ?, ?)';
		$result = $db->query($sql, array($module, $controller, $action));
		if (!$result) {
			throw new Exception('Invalid resources fields: '."$module, $controller, $action");
		}
	}
	
	
	
} //End: class IndexService





