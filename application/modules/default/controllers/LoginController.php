<?php
class LoginController extends Zend_Controller_Action
{
	private $auth = null;
	
    public function init()
    {
        /* Initialize action controller here */
//		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
//    		&& $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
//	    	$this->_helper->layout()->disableLayout();
//			$this->_helper->viewRenderer->setNoRender(TRUE);
//    	}
		require_once 'auth/AuthService.php';

	    if($this->_request->isXmlHttpRequest())
		{
//			$fc = Zend_Controller_Front::getInstance();
//			$fc->setParam('noViewRenderer', true);
			$this->_helper->layout()->disableLayout();
			$this->_helper->viewRenderer->setNoRender(TRUE);
		}

		$this->auth = new Zend_Session_Namespace('AUTH');
    }

    
    //登入页面
    public function indexAction()
    {
//		if($this->auth->user){
//			$this->_redirect('/');
//			exit;
//		}
//        $this->_redirect();
//		$test = array(1, 3, 5);
//        var_dump($test);
    }
    
    
    //验证登入
    public function loginAction()
    {
		
		$email = trim($this->_getParam('email'));
		$passwd = trim($this->_getParam('passwd'));
//		$passwd = '*15B4A9F089BEC4C84A24C5148B14A80C14651492';
//		var_dump(array($email, $passwd));
		
		$user = AuthService::authenticate($email, $passwd, array('role_id', 'email', 'nickname'));
//		var_dump($user);
		
		if ($user) {
//			$this->auth->setExpirationSeconds(86400);
			$this->auth->user = $user;
			echo $this->auth->user['nickname'];
		}
    }
    
    
    
    
    
    
    
    
}
//End: class IndexController