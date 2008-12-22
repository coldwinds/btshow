<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo __('created');?></th>
	<th><?php echo __('cv_type_id');?></th>
	<th><?php echo __('team_id');?></th>
	<th><?php echo __('title');?></th>
	<th><?php echo __('file_size');?></th>
	<th><?php echo __('seeders');?></th>
	<th><?php echo __('leechers');?></th>
	<th><?php echo __('completed');?></th>
	<th><?php echo __('publisher');?></th>
</tr>
<?php
$i = 0;
foreach ($data as $entry):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $entry['Torrent']['created']; ?>
		</td>
		<td>
			<?php echo $html->link($entry['CvType']['name'], array('controller'=> 'cv_types', 'action'=>'view', $entry['CvType']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($entry['Team']['name'], array('controller'=> 'teams', 'action'=>'view', $entry['Team']['id'])); ?>
		</td>
		<td>
			<?php echo $entry['Torrent']['is_commend'] ?  $html->link('R','/',array('class'=>'red_bold')): "" ; ?>
			<?php echo $html->link($entry['Torrent']['title'], array('controller' => 'torrents', 'action' => 'view', $entry['Torrent']['id'])) ?>
		</td>
		<td>
			<?php echo $entry['XbtFile']['seeders']; ?>
		</td>
		<td>
			<?php echo $entry['XbtFile']['leechers']; ?>
		</td>
		<td>
			<?php echo $entry['XbtFile']['completed']; ?>
		</td>
		<td>
			<?php echo $entry['Torrent']['file_size']; ?>
		</td>
		<td>
			<?php echo $entry['User']['username']?>
		</td>
	</tr>
<?php endforeach; ?>
</table>