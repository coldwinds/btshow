<div class="wrap_block" style="border:0;">
	<?php echo $this->element('torrents_category', array('cache' => '1 day'))?>
</div>



<div class="wrap_block">
	<center><input type="text" style="width:200px;" /><input type="submit" value="搜索" /></center>
</div>





<div class="wrap_block" style="border:0;">
	<ul class="block_title">
		<li class="title"><?php echo $html->link('热门推荐', '/')?></li>
		<li class="rss"><?php echo $html->link('订阅这个栏目', '/')?></li>
	</ul>
	<?php echo $this->element('torrents_top', array('cache' => '1 day'))?>
</div>

<div class="wrap_block" style="border:0;">
	<ul class="block_title">
		<li class="title"><?php echo $html->link('最近发布', '/')?></li>
		<li class="rss"><?php echo $html->link('订阅这个栏目', '/')?></li>
	</ul>
	<?php echo $this->element('torrents_new', array('cache' => '1 day'))?>
</div>