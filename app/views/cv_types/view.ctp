<div class="cvTypes view">
<h2><?php  __('CvType');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cvType['CvType']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $cvType['CvType']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit CvType', true), array('action'=>'edit', $cvType['CvType']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete CvType', true), array('action'=>'delete', $cvType['CvType']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $cvType['CvType']['id'])); ?> </li>
		<li><?php echo $html->link(__('List CvTypes', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New CvType', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
