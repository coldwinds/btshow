<div class="cvTypes form">
<?php echo $form->create('CvType');?>
	<fieldset>
 		<legend><?php __('Add CvType');?></legend>
	<?php
		echo $form->input('type');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List CvTypes', true), array('action'=>'index'));?></li>
	</ul>
</div>
