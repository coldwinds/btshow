<?php
class Torrent extends AppModel {

	var $name = 'Torrent';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Team' => array('className' => 'Team',
								'foreignKey' => 'team_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'CvType' => array('className' => 'CvType',
								'foreignKey' => 'cv_type_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'XbtFile' => array('className' => 'XbtFile',
								'foreignKey' => 'info_hash',
								'conditions' => '',
								'fields' => array('leechers','seeders','completed'),
								'order' => ''
			)
	);
	
	public $hasOne	=	array(
		'TorrentDetail' => array(
									'className' => 'TorrentDetail',
									'foreignKey' => 'torrent_id',
									'dependent' => false,
									'conditions' => '',
									'fields' => '',
									'order' => ''
		)
	);

}