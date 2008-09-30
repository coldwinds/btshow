<?php
class TorrentDetail extends AppModel {

	var $name = 'TorrentDetail';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Torrent' => array('className' => 'Torrent',
								'foreignKey' => 'torrent_id',
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
			'CvTopic' => array('className' => 'CvTopic',
								'foreignKey' => 'cv_topic_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'CvGenre' => array('className' => 'CvGenre',
								'foreignKey' => 'cv_genre_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'CvFormat' => array('className' => 'CvFormat',
								'foreignKey' => 'cv_format_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'CvOrigin' => array('className' => 'CvOrigin',
								'foreignKey' => 'cv_origin_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>