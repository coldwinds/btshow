<?php
class AppController extends Controller {
	// acl support
	var $components = array('Auth', 'Acl');
	
	function beforeFilter() {
		//FIXME 临时允许所有action,在最后阶段配置权限
		$this->Auth->allowedActions = array('*');
		
		//Configure AuthComponent
		$this->Auth->authorize = 'actions';
		$this->Auth->actionPath = 'controllers/';
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'torrents', 'action' => 'index');
		$this->Auth->loginRedirect = array('controller' => 'torrents', 'action' => 'index');
	}

}
?>