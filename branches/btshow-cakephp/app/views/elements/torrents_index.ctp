<?php
$torrents = $this->requestAction(array('controller' => 'torrents', 'action' => 'index', 'sort'=>'created' ,'direction'=>'desc'));
echo $this->element('torrents_table', array('data' => $torrents))
?>
	