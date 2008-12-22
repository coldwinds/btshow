<?php
class IndexController extends AppController {
	var $name = 'Index';
	var $helpers = array('Html', 'Form');
	var $uses	=	array();


	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('*');
	}

	function index() {
	}

}