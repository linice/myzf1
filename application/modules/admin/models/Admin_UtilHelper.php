<?php
	
	function getAndSaveResources() {
		$db = Zend_Registry::get('DB');
//		$controller = get_class();
		$actions = get_class_methods(__CLASS__);
		var_dump(__CLASS__);
		var_dump($actions);
	}
