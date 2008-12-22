<div class="cvTopics view">
<h2><?php  __('CvTopic');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cvTopic['CvTopic']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cvTopic['CvTopic']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Intro'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cvTopic['CvTopic']['intro']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CvTopic', true), array('action'=>'edit', $cvTopic['CvTopic']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CvTopic', true), array('action'=>'delete', $cvTopic['CvTopic']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cvTopic['CvTopic']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CvTopics', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CvTopic', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Torrent Details', true), array('controller'=> 'torrent_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Torrent Details');?></h3>
	<?php if (!empty($cvTopic['TorrentDetail'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Part Number'); ?></th>
		<th><?php __('Torrent Filelist'); ?></th>
		<th><?php __('Torrent Id'); ?></th>
		<th><?php __('Cv Type Id'); ?></th>
		<th><?php __('Cv Topic Id'); ?></th>
		<th><?php __('Cv Genre Id'); ?></th>
		<th><?php __('Cv Format Id'); ?></th>
		<th><?php __('Cv Origin Id'); ?></th>
		<th><?php __('Intro'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($cvTopic['TorrentDetail'] as $torrentDetail):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $torrentDetail['id'];?></td>
			<td><?php echo $torrentDetail['part_number'];?></td>
			<td><?php echo $torrentDetail['torrent_filelist'];?></td>
			<td><?php echo $torrentDetail['torrent_id'];?></td>
			<td><?php echo $torrentDetail['cv_type_id'];?></td>
			<td><?php echo $torrentDetail['cv_topic_id'];?></td>
			<td><?php echo $torrentDetail['cv_genre_id'];?></td>
			<td><?php echo $torrentDetail['cv_format_id'];?></td>
			<td><?php echo $torrentDetail['cv_origin_id'];?></td>
			<td><?php echo $torrentDetail['intro'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'torrent_details', 'action'=>'view', $torrentDetail['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'torrent_details', 'action'=>'edit', $torrentDetail['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'torrent_details', 'action'=>'delete', $torrentDetail['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $torrentDetail['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
