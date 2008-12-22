<?php
require_once("lib/thread.php");

function watchlist($id, $limit = 20){
	$thread = getthread($id);
	if(!$thread)
		return false;
	
	echo "Watchlist: ", $thread['title'],"\n";
	echo "分类\t发布时间\t标题\t尺寸\t作者\n";
	foreach($thread['posts'] as $postpath){
		$post = getpost($postpath);
		echo "<a href=\"type.php?name={$post['type']}\">{$post['type']}</a>\t";
		echo "{$post['date']}\t";
		echo "<a href=\"thread.php?id={$post['id']}\">{$post['title']}</a>\t";
		echo "{$post['size']}\t";
		echo "<a href=\"user.php?name={$post['author']}\">{$post['author']}</a>\n";
	}
	echo "\n";
}

