<div class="teams form">
<?php echo $form->create('Team');?>
	<fieldset>
 		<legend><?php __('Add Team');?></legend>
	<?php
		echo $form->input('name');
		echo $form->input('introduce');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Teams', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
