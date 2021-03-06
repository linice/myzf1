<?php

class Admin_AclService {
	/**
	 * resource：搜索资源，并保
	 * @param string $modulesDir：模块路径，如：APPLICATION_PATH . '/modules'
	 */
	public static function searchAndSaveResources($modulesDir = null) {
		$resources = array();
		$modules = array();
		$controllers = array();
		if(is_dir($modulesDir)){
			//搜索modules
			$d = dir($modulesDir);
			while ($file = $d->read()) {
				if (filetype($modulesDir.'/'.$file)=='dir' && substr($file, 0, 1) != '.') {
					$modules[] = $file;
				}
			}
//			var_dump($modules);

			//搜索controllers
			foreach ($modules as $module) {
				$controllersDir = $modulesDir.'/'.$module.'/controllers';
//				var_dump($controllersDir);
//				self::searchControllers($controllersDir, $controllers[]);
				//$controllers[$module]：表示此$module下的所有controllers
				self::searchControllers($controllersDir, $controllers[$module]);
			}
//			var_dump($resources);
//			echo '<br />';

			//搜索actions
//			$controllerFiles = array();
			$actions = array();
			foreach ($controllers as $m => $cs) {
				foreach ($cs as $c) {
					$cShortDir = str_replace('_', '/', $c);
					$controllerFile = $modulesDir.'/'.$m.'/controllers/'.$cShortDir.'Controller.php';
//					$controllerFiles[] = $modulesDir.'/'.$m.'/controllers/'.$c.'Controller.php';
					$lines = file($controllerFile);
					foreach ($lines as $line) {
						preg_match('/function\s+[a-z][a-z0-9]*Action\s*\(\)/', $line, $matchesOrigin);
						if (isset($matchesOrigin[0]) && $matchesOrigin[0] != '') {
							preg_match('/[a-z][a-z0-9]*Action/', $matchesOrigin[0], $matches);
							$actions[] = substr($matches[0], 0, -6);
						}
					}
					$resources[$m][$c] = $actions;
					$actions = array();
				}
			} //End: foreach ($controllers as $m => $cs)
//			var_dump($controllerFiles);
//			var_dump($resources);

//			self::saveResource('default', 'index', 'index');
			foreach ($resources as $m => $cs) {
				foreach ($cs as $c => $as) {
					foreach ($as as $a) {
						self::saveResource($m, $c, $a);
					}
				}
			}
		} //End: if(is_dir($modulesDir))
	}
	
	
	/**
	 * 搜索控制器
	 * @param unknown_type $controllersDir
	 * @param unknown_type $controllers
	 */
	public static function searchControllers($controllersDir = null, &$controllers = array()) {
		if(is_dir($controllersDir)){
			$d = dir($controllersDir);
			while($file = $d->read()) {
				if(filetype($controllersDir.'/'.$file) == 'dir' && substr($file, 0, 1) != '.') {
					$subControllersDir = $controllersDir.'/'.$file;
//					echo $subControllersDir.'<br />';
					self::searchControllers($subControllersDir, $controllers);
				} elseif (filetype($controllersDir.'/'.$file) == 'file' && substr($file, -14) == 'Controller.php') {
					//非首次递归调用时，controllers下的子文件夹名，加在具体的controller短名字前，中间用下划线隔开。
					if (substr($controllersDir, -11) != 'controllers') {
						//12表示“controllers/”的长度
						$tailControllersDir = substr($controllersDir, strpos($controllersDir, 'controllers')+12);
						$tailControllersDir = str_replace('/', '_', $tailControllersDir);
						$controllers[] = $tailControllersDir.'_'.substr($file, 0, -14);
					} else {
						$controllers[] = substr($file, 0, -14);
					}
				}
			}
		}
	}
	
	
	/**
	 * resource：保存
	 * Enter description here ...
	 * @param string $module
	 * @param string $controller
	 * @param string $action
	 */
	public static function saveResource($module=null, $controller=null, $action=null) {
		$db = Zend_Registry::get('DB');
		$sql = 'insert resource(code, module, controller, action) values(?, ?, ?, ?)';
		$code = $module.'/'.$controller.'/'.$action;
		$result = $db->query($sql, array($code, $module, $controller, $action));
		if (!$result) {
			throw new Exception('Invalid resource fields: '."$module, $controller, $action");
		}
	}
	
	
	/**
	 *  resource：查询
	 * @param array(string) $fields
	 */
	public static function getResources($fields = array('*')) {
		$db = Zend_Registry::get('DB');
		$strFields = implode(',', $fields);
		$sql = "select $strFields from resource";
		$stmt = $db->query($sql);
		$result = $stmt->fetchAll();
		return $result;
	}
}