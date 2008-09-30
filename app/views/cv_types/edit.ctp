<div class="cvTypes form">
<?php echo $form->create('CvType');?>
	<fieldset>
 		<legend><?php __('Edit CvType');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('type');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('CvType.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('CvType.id'))); ?></li>
		<li><?php echo $html->link(__('List CvTypes', true), array('action'=>'index'));?></li>
	</ul>
</div>
