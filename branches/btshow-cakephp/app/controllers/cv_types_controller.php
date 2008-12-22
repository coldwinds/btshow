<?php
class CvTypesController extends AppController {

	var $name = 'CvTypes';
	var $helpers = array('Html', 'Form');
	var $components = array('RequestHandler');

	function index() {
		$this->CvType->recursive = 0;
		$cvTypes = $this->paginate();
		if(isset($this->params['requested'])) {
             return $cvTypes;
        }
		$this->set('cvTypes', $cvTypes);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid CvType.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->CvType->recursive = 0;
		$this->set('cvType', $this->CvType->read(null, $id));
		
		$entry = $this->paginate('Torrent',array('Torrent.cv_type_id'=>$id));
		$this->set('entry', $entry);
	}

	function add() {
		if (!empty($this->data)) {
			$this->CvType->create();
			if ($this->CvType->save($this->data)) {
				if ($this->RequestHandler->isAjax()) {
					Configure::write('debug', 0);
					$this->data['CvType']['id'] = $this->CvType->id;
					echo json_encode($this->data['CvType']);
					exit;
				}
				$this->Session->setFlash(__('The CvType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvType could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid CvType', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->CvType->save($this->data)) {
				$this->Session->setFlash(__('The CvType has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The CvType could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->CvType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for CvType', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->CvType->del($id)) {
			$this->Session->setFlash(__('CvType deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>