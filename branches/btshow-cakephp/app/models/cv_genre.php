<?php
class CvGenre extends AppModel {

	var $name = 'CvGenre';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'TorrentDetail' => array('className' => 'TorrentDetail',
								'foreignKey' => 'cv_genre_id',
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