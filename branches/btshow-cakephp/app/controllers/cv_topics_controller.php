<?php
class CvTopicsController extends AppController {

	var $name = 'CvTopics';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CvTopic->recursive = 0;
		$this->set('cvTopics', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CvTopic.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cvTopic', $this->CvTopic->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CvTopic->create();
			if ($this->CvTopic->save($this->data)) {
				$this->Session->setFlash(__('The CvTopic has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvTopic could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CvTopic', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CvTopic->save($this->data)) {
				$this->Session->setFlash(__('The CvTopic has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvTopic could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CvTopic->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CvTopic', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CvTopic->del($id)) {
			$this->Session->setFlash(__('CvTopic deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>