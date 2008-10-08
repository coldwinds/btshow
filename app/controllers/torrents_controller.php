<?php
class TorrentsController extends AppController {
	var $name = 'Torrents';
	var $helpers = array('Html', 'Form');
	var $components = array('TorrentParser');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view');
	}


	function index() {
		$this->Torrent->recursive = 0;
		$torrents	=	$this->paginate();
		if(isset($this->params['requested'])) {
             return $torrents;
        }
		$this->set('torrents', $torrents);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Torrent.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Torrent->contain(array('TorrentDetail', 'User', 'Team', 'CvType', 'XbtFile'));
		$this->set('torrent', $this->Torrent->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			/** 用户信息 */
			$auth = $this->Auth->user();
			if($auth){
				$this->data['Torrent']['user_id'] = $auth['User']['id'];
				$this->data['Torrent']['team_id'] = $auth['User']['team_id'];
				$this->data['Torrent']['publisher'] = $auth['User']['username'];
			}else{
				$this->Session->setFlash(__('You need to login.', true));
				$this->redirect(array('action'=>'index'));
				return;
			}
			/* 解析文件 */
			$fn = $this->data['Torrent']['tfile']['tmp_name'];
			$torrent_info = $this->TorrentParser->parse_file($fn);
			$des_file = WWW_ROOT.'files'.DS.$torrent_info['info_hash'].'.torrent';
			if(file_exists($des_file)){
				$res = $this->Torrent->findByInfoHash(pack('H*',$torrent_info['info_hash']));
				if($res){
					$this->Torrent->id = $res['Torrent']['id'];
					$this->Torrent->saveField('is_reseed',1);
					$this->Session->setFlash(__('The Torrent has been reseed', true));
					$this->redirect(array('action'=>'index'));
					return;
				}
			}
			// 保存文件
			move_uploaded_file($fn,  $des_file);

			//保存xbt_file
			$this->data['XbtFile']['info_hash'] = pack('H*',$torrent_info['info_hash']);
			$this->data['XbtFile']['mtime'] = time();
			$this->data['XbtFile']['ctime'] = time();
			$this->Torrent->XbtFile->save($this->data);

			$this->data['TorrentDetail']['torrent_filelist'] = serialize($torrent_info['files']);
			$this->data['Torrent']['file_size'] = $torrent_info['size'];
			$this->data['Torrent']['info_hash'] = pack('H*',$torrent_info['info_hash']);

			$this->Torrent->create();
			if ($this->Torrent->save($this->data)) {
				$this->data['TorrentDetail']['cv_type_id'] = $this->data['Torrent']['cv_type_id'];
				$this->data['TorrentDetail']['torrent_id'] = $this->Torrent->id;
				$this->Torrent->TorrentDetail->save($this->data);

				$this->Session->setFlash(__('The Torrent has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Torrent could not be saved. Please, try again.', true));
			}
		}
		$cvTypes = $this->Torrent->CvType->find('list');
		$cvTopics = $this->Torrent->TorrentDetail->CvTopic->find('list');
		$cvGenres = $this->Torrent->TorrentDetail->CvGenre->find('list');
		$cvFormats = $this->Torrent->TorrentDetail->CvFormat->find('list');
		$cvOrigins = $this->Torrent->TorrentDetail->CvOrigin->find('list');
		$this->set(compact('cvTypes', 'cvTopics', 'cvGenres', 'cvFormats', 'cvOrigins'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Torrent', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Torrent->save($this->data)) {
				$this->Session->setFlash(__('The Torrent has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Torrent could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Torrent->read(null, $id);
		}
		$cvTypes = $this->Torrent->CvType->find('list');
		$cvTopics = $this->Torrent->TorrentDetail->CvTopic->find('list');
		$cvGenres = $this->Torrent->TorrentDetail->CvGenre->find('list');
		$cvFormats = $this->Torrent->TorrentDetail->CvFormat->find('list');
		$cvOrigins = $this->Torrent->TorrentDetail->CvOrigin->find('list');
		$this->set(compact('cvTypes', 'cvTopics', 'cvGenres', 'cvFormats', 'cvOrigins'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Torrent', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Torrent->del($id)) {

			$this->Session->setFlash(__('Torrent deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>