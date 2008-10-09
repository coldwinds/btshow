<?php
$categories = $this->requestAction(array('controller' => 'cvTypes', 'action' => 'index'));

foreach ($categories as $category) {
	echo $html->link($category['CvType']['name'], '/') . ' ';
}
?>