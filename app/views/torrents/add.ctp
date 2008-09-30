<div class="torrents form">
<?php echo $form->create('Torrent',array('type'=>'file'));?>
	<fieldset>
 		<legend><?php __('Add Torrent');?></legend>
	<?php
		echo $form->input('cv_type_id');
		echo $form->input('TorrentDetail.cv_topic_id');
		echo $form->input('TorrentDetail.cv_genre_id');
		echo $form->input('TorrentDetail.cv_format_id');
		echo $form->input('TorrentDetail.cv_origin_id');
		
		echo $form->file('tfile');
		echo $form->input('title');
		echo $form->input('link_url');
		echo $form->input('TorrentDetail.intro');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Torrents', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Teams', true), array('controller'=> 'teams', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Team', true), array('controller'=> 'teams', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Cv Types', true), array('controller'=> 'cv_types', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Cv Type', true), array('controller'=> 'cv_types', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Torrent Details', true), array('controller'=> 'torrent_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add')); ?> </li>
	</ul>
</div>
