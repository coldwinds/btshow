<div class="cvGenres form">
<?php echo $form->create('CvGenre');?>
	<fieldset>
 		<legend><?php __('Edit CvGenre');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('name');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CvGenre.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CvGenre.id'))); ?></li>
		<li><?php echo $html->link(__('List CvGenres', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Torrent Details', true), array('controller'=> 'torrent_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add')); ?> </li>
	</ul>
</div>
