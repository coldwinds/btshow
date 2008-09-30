<div class="cvGenres index">
<h2><?php __('CvGenres');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($cvGenres as $cvGenre):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $cvGenre['CvGenre']['id']; ?>
		</td>
		<td>
			<?php echo $cvGenre['CvGenre']['name']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $cvGenre['CvGenre']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $cvGenre['CvGenre']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $cvGenre['CvGenre']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cvGenre['CvGenre']['id'])); ?>
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
		<li><?php echo $html->link(__('New CvGenre', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Torrent Details', true), array('controller'=> 'torrent_details', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Torrent Detail', true), array('controller'=> 'torrent_details', 'action'=>'add')); ?> </li>
	</ul>
</div>
