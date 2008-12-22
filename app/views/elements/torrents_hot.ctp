<?php
$torrents = $this->requestAction(array('controller' => 'torrents', 'action' => 'hot'));
echo $this->element('torrents_table', array('data' => $torrents))
?>
