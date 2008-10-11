<?php
$categories = $this->requestAction(array('controller' => 'cvTypes', 'action' => 'index'));
?>

<div id="cv_type_menu">
	<ul>
		<?php foreach ($categories as $category): ?>
		<li><?php echo $html->link($category['CvType']['name'], 
					array('controller'=> 'cv_types', 
							'action'=>'view', 
							$category['CvType']['id'])); ?></li>
		<li class="separatorDiv"></li>
		<?php endforeach; ?>
	</ul>
</div>
