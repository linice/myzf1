<?php
// application/Bootstrap.php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initView()
    {
        // Initialize view
        $view = new Zend_View(array('encoding'=>'UTF-8'));
        //下面3句来自Zend/view/Helper/Doctype.php
//        const XHTML11             = 'XHTML11';
//    	const XHTML1_STRICT       = 'XHTML1_STRICT';
//    	const XHTML1_TRANSITIONAL = 'XHTML1_TRANSITIONAL';
        $view->doctype('XHTML1_TRANSITIONAL');
        $view->headTitle('CentOS ZF');
 
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->setView($view);
        
		Zend_Registry::set('LAYOUT', $view);
 
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }
    
    
	/**
	 * 初始化Log
	 */
	protected function _initLog() {
		Zend_Registry::set('LOG_FULL_FILENAME', APPLICATION_PATH . '/../public/log/gcentos.log');
	}
    
    
    //把初始化Db移到文件index.php里，因为那里用到了配置文件application.ini
	//方法一（多个数据库）
	protected function _initDb() {
		$resource = $this->getPluginResource('multidb');
		$resource->init();
		$dbTest = $resource->getDb('test');
//		$dbLos = $resource->getDb('los');
//		Zend_Db_Table_Abstract::setDefaultAdapter($dbTest);
//		$dbTest->query('set names utf8');
		
		Zend_Registry::set('DB', $dbTest);
		
		
		$resource = $this->getPluginResource('multidb');
		$resource->init();
		$dbTest = $resource->getDb('istore2');
//		$dbLos = $resource->getDb('los');
//		Zend_Db_Table_Abstract::setDefaultAdapter($dbTest);
//		$dbTest->query('set names utf8');
		
		Zend_Registry::set('DB_ISTORE2', $dbTest);
	}

    
    //把初始化Db移到文件index.php里，因为那里用到了配置文件application.ini
    //方法二（单个数据库）
//	protected function _initDb2() {
//		$config = new Zend_Config_Ini('configs/application.ini', 'development');
//		Zend_Registry::set('config', $config);
//		$dbTest = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params->toArray());
//		$dbTest->query('set names utf8');
//		Zend_Db_Table_Abstract::setDefaultAdapter($dbTest);
//		Zend_Registry::set('DB', $dbTest);
//	}

    
    protected function _initSession() {
		$config = array(
		    'name'           => 'session',
		    'primary'        => 'id',
		    'modifiedColumn' => 'modified',
		    'lifetimeColumn' => 'lifetime',
		    'dataColumn'     => 'data'
		);
		
		//create your Zend_Session_SaveHandler_DbTable and
		//set the save handler for Zend_Session
		Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_DbTable($config));
		 
		//start your session!
		Zend_Session::start();
    }
	
    
    //国际化
    protected function _initTranslate ()
	{
		$resources = $this->getOption('resources');
		$resource = $resources['translate'];
//		$resource = $this->getPluginResource('translate');
		if (!isset($resource['data'])) {
			throw new Zend_Application_Resource_Exception('对不起,没有找到语言文件！');
		}
		$adapter = isset($resource['adapter']) ? $resource['adapter'] : Zend_Translate::AN_ARRAY;
		$session = new Zend_Session_Namespace('AUTH');
		//判断session里是否写了locale变量，如果有则取session的变量，
		//否则，取系统配置application.ini的默认locale
		//因此，可以在主页里设置中、英文切换按钮。
		//也可以在cookie里设置locale
		if ($session->locale) {
			$locale = $session->locale;
		} else {
			$locale =isset($resource['locale']) ? $resource['locale'] : 'zh_CN';
		}
		$data = '';
		if (isset($resource['data'][$locale])) {
			$data = $resource['data'][$locale];
		}
		$translateOptions =isset($resource['options']) ? $resource['options'] : array();
		$translate = new Zend_Translate($adapter, $data, $locale, $translateOptions);
		Zend_Form::setDefaultTranslator($translate);
		Zend_Registry::set($resource['registry_key'], $translate);
//		echo 'locale in bootstrap: ' . $locale;
		return $translate;
	}
	
	
	/**
	 * 测试初始化函数
	 */
	protected function _test() {
		$dt = date('Y-m-d H:i:s');
		echo $dt;
	}
    
	
} //End: application/Bootstrap.php