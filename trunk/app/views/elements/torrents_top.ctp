<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo __('created');?></th>
	<th><?php echo __('cv_type_id');?></th>
	<th><?php echo __('team_id');?></th>
	<th><?php echo __('is_commend');?></th>
	<th><?php echo __('title');?></th>
	<th><?php echo __('leechers');?></th>
	<th><?php echo __('seeders');?></th>
	<th><?php echo __('completed');?></th>
	<th><?php echo __('file_size');?></th>
	<th><?php echo __('publisher');?></th>
</tr>
<?php
$torrents = $this->requestAction(array('controller' => 'torrents', 'action' => 'index', 'getType' => 'top'));
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
			<?php echo $torrent['CvType']['name']?>
		</td>
		<td>
			<?php echo $torrent['Team']['name']?>
		</td>
		<td>
			<?php echo $torrent['Torrent']['is_commend']; ?>
		</td>
		<td>
			<?php echo $html->link($torrent['Torrent']['title'], array('controller' => 'torrents', 'action' => 'view', $torrent['Torrent']['id'])) ?>
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
			<?php echo $torrent['User']['username']?>
		</td>
	</tr>
<?php endforeach; ?>
</table>