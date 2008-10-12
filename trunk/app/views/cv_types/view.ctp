<ul class="block_title">
	<li class="title"><?php echo $html->link($cvType['CvType']['name'], '/')?></li>
	<li class="rss"><?php echo $html->link('订阅这个栏目', '/')?></li>
</ul>
<div class="torrents">
<p><?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<?php echo $this->element('torrents_table', array('data' => $entry));?>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>

