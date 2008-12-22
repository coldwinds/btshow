<?php
class CvType extends AppModel {

	var $name = 'CvType';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'TorrentDetail' => array('className' => 'TorrentDetail',
								'foreignKey' => 'cv_type_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			),
			'Torrent' => array('className' => 'Torrent',
								'foreignKey' => 'cv_type_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>