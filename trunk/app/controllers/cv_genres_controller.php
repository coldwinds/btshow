<?php
class CvGenresController extends AppController {

	var $name = 'CvGenres';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->CvGenre->recursive = 0;
		$this->set('cvGenres', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CvGenre.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('cvGenre', $this->CvGenre->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->CvGenre->create();
			if ($this->CvGenre->save($this->data)) {
				$this->Session->setFlash(__('The CvGenre has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvGenre could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CvGenre', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CvGenre->save($this->data)) {
				$this->Session->setFlash(__('The CvGenre has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvGenre could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CvGenre->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CvGenre', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CvGenre->del($id)) {
			$this->Session->setFlash(__('CvGenre deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>