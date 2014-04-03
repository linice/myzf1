<?php
class PhpinfoController extends Zend_Controller_Action
{
	private $auth = null;
	
	
    public function init()
    {
//        require_once 'acl/permission.php';
        
    	if($this->_request->isXmlHttpRequest())
		{
	    	$this->_helper->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(TRUE);
		}

		$this->auth = new Zend_Session_Namespace('AUTH');
    }
    
	
    public function indexAction()
    {
        $layout = Zend_Registry::get('LAYOUT');
//        $layout->navs[0]['uri'] = '/phpinfo';
//        $layout->navs[0]['name'] = 'phpinfo';
		$nav = array('uri'=>'/phpinfo', 'name'=>'phpinfo');
        $layout->crumbs = array($nav);
        
//        $this->view->render('phpinfo/index.phtml');
		//下面这句话会输出view：test/index.phtml
		//前提是该Action首先能找到自己的view，否则会出错
//        echo $this->view->render('test/index.phtml');
		$module = $this->_request->getModuleName();
		$controller = $this->_request->getControllerName();
		$action = $this->_request->getActionName();
		$uri = $this->_request->getRequestUri();
		var_dump(array($module, $controller, $action, $uri));
    }
    
    
    
    


} //End: class PhpinfoController
