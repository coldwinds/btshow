<?php
// application/controllers/IndexController.php

/**
 * IndexController is the default controller for this application
 *
 * Notice that we do not have to require 'Zend/Controller/Action.php', this
 * is because our application is using "autoloading" in the bootstrap.
 *
 * @see http://framework.zend.com/manual/en/zend.loader.html#zend.loader.load.autoload
 */
class IndexController extends Zend_Controller_Action
{
	/**
	 * The "index" action is the default action for all controllers. This
	 * will be the landing page of your application.
	 *
	 * Assuming the default route and default router, this action is dispatched
	 * via the following urls:
	 *   /
	 *   /index/
	 *   /index/index
	 *
	 * @return void
	 */
	public function indexAction()
	{
		$this->view->headTitle('首页');

		$this->_helper->actionStack('index','topics');
		//公告
		$this->_helper->actionStack('index','announce');
		//置顶		
		$this->_helper->actionStack('topped','topics');
		//您的位置
		$this->_helper->actionStack('index','breadcrumb');
	}
}
