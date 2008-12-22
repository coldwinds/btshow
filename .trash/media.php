<?php
require_once("lib/auth.php");
require_once("header.php");
/*
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "Create new a new franchise\n";
		echo "<form action=\"editmedia.php?action=add\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" /><br />\n";
		echo "Descryption: <br /><textarea name=\"descr\"></textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$media['title'] = $_POST['title'];
		$media['descr'] = $_POST['descr'];
		$media['id'] = mediaid();
		$id = putmedia($media);
		if(!$id)
			die('failure');
		header("Location: /btshow/media.php?id=$id");
	}
*/
require_once("lib/media.php");
if(!isset($_GET['id'])){
	echo "ALL MEDIA\n";
	if(rights('media','add'))
		echo "<a href=\"editmedia.php?action=add\">[new media]</a>\n";
	$media=allmedia();
	require_once("lib/alphabet.php");
	$a = alphabet($media);
	foreach($a as $section=>$items){
		echo " -- Section: $section --  \n";
		foreach($items as $media){
			echo "\t* <a href=\"media.php?id={$media['id']}\">{$media['title']}</a> (",count($media['topics']),")\n";
		}
	}
}else{
	$media = getmedia($_GET['id']);
	if(!$media)
		die('not found');
	echo $media['title'];
	if(rights('media','edit'))
		echo " <a href=\"editmedia.php?action=edit&id={$media['id']}\">[edit]</a>";
	if(rights('media','delete'))
		echo " <a href=\"editmedia.php?action=delete&id={$media['id']}\">[delete]</a>";
	echo "\n";

	echo "Description: ", $media['descr'], "\n";
	if(rights('topic','add'))
		echo "<a href=\"edittopic.php?action=add&id={$media['id']}\">[new topic]</a>\n";
	$types=array();
	foreach($media['topics'] as $topicid){
		$topic = gettopic($topicid);
		$types[$topic['type']][] = $topic;
	}
	ksort($types);
	foreach($types as $typename=>$type){
		echo " -- Type: $typename --\n";
		foreach($type as $topic){
			echo "\t* [",(time()>strtotime($topic['end'])?"ended":"ongoing"),"] {$topic['title']} ({$topic['start']} – {$topic['end']})";
			if(rights('topic','edit'))
				echo " <a href=\"edittopic.php?action=edit&id={$topic['id']}\">[edit]</a>";
			if(rights('topic','delete'))
				echo " <a href=\"edittopic.php?action=delete&id={$topic['id']}\">[delete]</a>";
			echo "\n";

			echo "\t\t# Description: {$topic['descr']} ";
			if(rights('thread','add'))
				echo "<a href=\"editthread.php?action=add&id={$topic['id']}\">[new thread]</a>\n";
			foreach($topic['threads'] as $threadid){
				$thread = getthread($threadid);
				echo "\t\t# Thread: [",($thread['ended']?"ended":"ongoing"),"] ";
				echo "<a href=\"thread.php?id={$thread['id']}\">{$thread['title']}</a> ";
				$authors = explode("\n", $thread['author']);
				foreach($authors as &$author){
					$u = getuser($author);
					$author = "<a href=\"user.php?name={$u['id']}\">{$u['name']}</a>";
				}
				echo "by ",implode(' &amp; ',$authors);
				echo " (",count($thread['posts']),")";
				if(rights('thread','edit',$thread['author']))
					echo " <a href=\"editthread.php?id={$thread['id']}&action=edit\">[edit]</a>";
				if(rights('thread','delete',$thread['author']))
					echo " <a href=\"editthread.php?id={$thread['id']}&action=delete\">[delete]</a>";
				echo "\n";
			}
		}
	}
}

require_once("footer.php");
