<?php

class TopicsController extends Zend_Controller_Action
{

	protected $_topicsModel;

	
	/**
	 * Enter description here...
	 *
	 * @return Model_Topics
	 */
	protected function _getTopicsModel()
	{
		if (null === $this->_topicsModel) {
			// autoload only handles "library" compoennts.  Since this is an
			// application model, we need to require it from its application
			// path location.
			require_once APPLICATION_PATH . '/model/Topics.php';
			$this->_topicsModel = new Model_Topics();
		}
		return $this->_topicsModel;
	}

	public function indexAction()
	{
		//$this->_helper->layout->setLayout('detail'); 选择布局
		$this->_forward('list');
	}

	public function listAction()
	{
		$model = $this->_getTopicsModel();
		$request  = $this->getRequest();
		
		$page = $request->getParam('page',1);
		$numPerPage = 55; //TODO 数量写死了
		
		$rst = $model->pageEntries($page,$numPerPage);
		
		$paginator = Zend_Paginator::factory((integer)$rst['count']['count(*)']);
		$paginator->setCurrentPageNumber($page)->setItemCountPerPage($numPerPage);
		
		
		//分页
		$this->view->paginator = $paginator;
		$this->view->entries = $rst['data'];
	}

	public function viewAction()
	{
		$model = $this->_getTopicsModel();
		$this->view->entries = $model->fetchEntry(1);
	}

	/**
	 * 热门
	 */
	public function cultAction()
	{

	}
	
	public function toppedAction(){
		
	}


}
