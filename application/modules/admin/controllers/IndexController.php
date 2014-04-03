<?php
include_once 'Acl/Admin_AclService.php';

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	include_once 'Admin_IndexService.php';
    }

    public function indexAction()
    {
        // action body
    }
    
    
    //搜索并保存所有资源
    public function searchandsaveresourcesAction() {
//    	$fc = Zend_Controller_Front::getInstance();
//    	$fc->setParam('noViewRenderer', true);
//    	$modulesDir = $fc->getModuleDirectory();
//    	$modulesDir .= '/..';
//		var_dump($modulesDir);
//		echo '<br />';
//		IndexService::searchAndSaveResources(APPLICATION_PATH.'/modules');
		Admin_AclService::searchAndSaveResources(APPLICATION_PATH . '/modules');
		exit;
    }


}