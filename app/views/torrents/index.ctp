<div class="torrents index">
<h2><?php __('Torrents');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('cv_type_id');?></th>
	<th><?php echo $paginator->sort('team_id');?></th>
	<th><?php echo $paginator->sort('is_commend');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo __('leechers');?></th>
	<th><?php echo __('seeders');?></th>
	<th><?php echo __('completed');?></th>
	<th><?php echo $paginator->sort('file_size');?></th>
	<th><?php echo $paginator->sort('publisher');?></th>
</tr>
<?php
$i = 0;
foreach ($torrents as $torrent):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $torrent['Torrent']['created']; ?>
		</td>
		<td>
			<?php echo $html->link($torrent['CvType']['name'], array('controller'=> 'cv_types', 'action'=>'view', $torrent['CvType']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($torrent['Team']['name'], array('controller'=> 'teams', 'action'=>'view', $torrent['Team']['id'])); ?>
		</td>
		<td>
			<?php echo $torrent['Torrent']['is_commend']; ?>
		</td>
		<td>
			<?php echo $torrent['Torrent']['title']; ?>
		</td>
		
		<td>
			<?php echo $torrent['XbtFile']['leechers']; ?>
		</td>
		<td>
			<?php echo $torrent['XbtFile']['seeders']; ?>
		</td>
		<td>
			<?php echo $torrent['XbtFile']['completed']; ?>
		</td>
		<td>
			<?php echo $torrent['Torrent']['file_size']; ?>
		</td>
		<td>
			<?php echo $html->link($torrent['User']['username'], array('controller'=> 'users', 'action'=>'view', $torrent['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Torrent', true), array('action'=>'add')); ?></li>
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
