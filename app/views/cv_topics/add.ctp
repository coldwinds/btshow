<div class="cvTopics form">
<?php echo $form->create('CvTopic');?>
	<fieldset>
 		<legend><?php __('Add CvTopic');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('intro');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CvTopics', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Torrent Details', true), array('controller'=> 'torrent_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add')); ?> </li>
	</ul>
</div>
