<?php
class TeamsController extends AppController {

	var $name = 'Teams';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Team->recursive = 0;
		$this->set('teams', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Team.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('team', $this->Team->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Team->create();
			if ($this->Team->save($this->data)) {
				$this->Session->setFlash(__('The Team has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Team could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Team', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Team->save($this->data)) {
				$this->Session->setFlash(__('The Team has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Team could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Team->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Team', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Team->del($id)) {
			$this->Session->setFlash(__('Team deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>