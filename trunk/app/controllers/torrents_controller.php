<?php
class TorrentsController extends AppController {

	var $name = 'Torrents';
	var $helpers = array('Html', 'Form');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allowedActions = array('index', 'view');
	}


	function index() {
		$this->Torrent->recursive = 0;
		$this->set('torrents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Torrent.', true));
			$this->redirect(array('action'=>'index'));
		}
		//动态增加表关联 Creating Associations on the Fly		
		$this->Torrent->bindModel(
		array('hasOne'=>array(
					'TorrentDetail' => array(
									'className' => 'TorrentDetail',
									'foreignKey' => 'torrent_id',
									'dependent' => false,
									'conditions' => '',
									'fields' => '',
									'order' => '')
		)
		)
		);
		$this->set('torrent', $this->Torrent->read(null, $id));
	}

	function add() {
		//动态增加表关联 Creating Associations on the Fly		
		$this->Torrent->bindModel(
		array('hasOne'=>array(
					'TorrentDetail' => array(
									'className' => 'TorrentDetail',
									'foreignKey' => 'torrent_id',
									'dependent' => false,
									'conditions' => '',
									'fields' => '',
									'order' => '')
		)
		));
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
			App::import('Vendor','TorrentFile');
			$obj = new TorrentFile();
			$torrent_info = $obj->parse_file($fn);
			$des_file = WWW_ROOT.'files'.DS.$torrent_info[0]['info_hash'].'.torrent';
			if(file_exists($des_file)){
				$res = $this->Torrent->findByInfoHash(pack('H*',$torrent_info[0]['info_hash']));
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
			$this->data['XbtFile']['info_hash'] = pack('H*',$torrent_info[0]['info_hash']);
			$this->data['XbtFile']['mtime'] = time();
			$this->data['XbtFile']['ctime'] = time();
			$this->Torrent->XbtFile->save($this->data);
			//文件列表
			$count_file_size = 0;
			$file_list = array();
			if(isset($torrent_info[0]['info']['files'])){
				foreach ( $torrent_info[0]['info']['files'] as $value ){
					$file = array();
					$file['length']= (int)$value['length'];
					if(is_array($value['path'])){
						$file['name'] = $value['path'][0];
					}else{
						if(isset($value['path.utf-8'])){
							$file['name']= $value['path.utf-8'];
						}else{
							$file['name']= $value['path'];
						}
					}
					$file_list[] = $file;
					$count_file_size += (int) $value['length'];
				}
			}
			if(isset($torrent_info[0]['info']['length'])){
				$count_file_size += (int) $torrent_info[0]['info']['length'];
				$file = array();
				$file['name'] = $torrent_info[0]['info']['name.utf-8'];
				$file['length'] = $torrent_info[0]['info']['length'];
				$file_list[] = $file;
			}
			$this->data['TorrentDetail']['torrent_filelist'] = serialize($file_list);
			$this->data['Torrent']['file_size'] = $count_file_size;
			$this->data['Torrent']['info_hash'] = pack('H*',$torrent_info[0]['info_hash']);

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
		//动态增加表关联 Creating Associations on the Fly		
		$this->Torrent->bindModel(
		array('hasOne'=>array(
					'TorrentDetail' => array(
									'className' => 'TorrentDetail',
									'foreignKey' => 'torrent_id',
									'dependent' => false,
									'conditions' => '',
									'fields' => '',
									'order' => '')
		)
		)
		);
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