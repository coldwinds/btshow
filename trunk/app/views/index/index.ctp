<div class="wrap_block" style="border:0;">
	<?php echo $this->element('torrents_category', array('cache' => '0 day'))?>
</div>

<div class="wrap_block">
	<center>
		<?php echo $form->create('Torrent', array('action' => 'search'))?>
		<?php echo $form->input('s', array('label' => '关键字：', 'div' => false))?>
		<?php echo $form->end(array('label' => '搜索', 'div' => false))?>
	</center>
</div>





<div class="wrap_block" style="border:0;">
	<ul class="block_title">
		<li class="title"><?php echo $html->link('热门推荐', '/')?></li>
		<li class="rss"><?php echo $html->link('订阅这个栏目', '/')?></li>
	</ul>
	<?php echo $this->element('torrents_hot', array('cache' => '0 day'))?>
</div>

<div class="wrap_block" style="border:0;">
	<ul class="block_title">
		<li class="title"><?php echo $html->link('最近发布', '/')?></li>
		<li class="rss"><?php echo $html->link('订阅这个栏目', '/')?></li>
	</ul>
	<?php echo $this->element('torrents_index', array('cache' => '0 day'))?>
</div>