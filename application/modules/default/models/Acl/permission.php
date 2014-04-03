<?php
//设计原则是，用户（guest, member, staff, editor, admin）能看到的就是能操作的，
//不能看到的（即不能操作的），也可能通过url来访问。
//此时，就需要验证用户是否已登陆，若已登陆，则判断该用户是否有权限访问。

//检查用户是否已登陆，若未登陆，返回未登陆信息（Ajax），转到登陆页面（Not Ajax）。
$auth = new Zend_Session_Namespace('AUTH');
//var_dump($auth->user['email']);
//exit;
if (!$auth || !$auth->user || !$auth->user['email']) {
	$ret['isLogin'] = 0;
	$ret['isAllow'] = 0;
	$ret['permissonMsg'] = '你还没有登录！<a href="/login">现在登录！</a>';
	if($this->_request->isXmlHttpRequest()){
    	echo json_encode($ret);
		exit;
    }else{
    	$this->_redirect('/login');
    	exit;
    }
}


//检查当前用户（根据用户角色）对即将访问的资源的权限
$module = trim(strtolower($this->_request->getModuleName()));
$controller = trim(strtolower($this->_request->getControllerName()));
$action = trim(strtolower($this->_request->getActionName()));
$db = Zend_Registry::get('DB');
$sql = "select 1 from permission
		where role_id = (select role_id from user where email = ?)
			and resource_id = (select id from resource 
								where module = ?
									and controller = ?
									and action = ?)";
$result = $db->fetchAll($sql, array($auth->user['email'], $module, $controller, $action));
if (!$result) {
	$ret['isLogin'] = 1;
	$ret['isAllow'] = 0;
	$ret['permissonMsg'] = '你没有权限访问此功能！';
	if($this->_request->isXmlHttpRequest()){
    	echo json_encode($ret);
		exit;
    } else {
    	echo '<script>alert("抱歉，你没有权限访问此功能！"); location.href="/";</script>';
    	exit;
    }
}


