<?php
class AppController extends Controller {
	// acl support
	var $components = array('Auth', 'Acl');

	function beforeFilter() {
		//Configure AuthComponent
		$this->Auth->userModel	=	'User';
		$this->Auth->authenticate	=	& $this->Auth->getModel();//默认为userModel
		$this->Auth->authorize = 'actions';
		$this->Auth->actionPath = 'controllers/';
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->Auth->logoutRedirect = array('controller' => 'torrents', 'action' => 'index');
		$this->Auth->loginRedirect = array('controller' => 'torrents', 'action' => 'index');
	}

}
?>