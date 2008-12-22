<?php
require_once('lib/init.php');
require_once('lib/media.php');

if($_GET['action']=='add'){
	if(!rights('topic','add'))
		die('no rights');
	$media = getmedia($_GET['id']);
	if(!$media)
		die('no such media');
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "Create a new topic of {$media['title']}\n";
		echo "<form action=\"edittopic.php?id={$media['id']}&action=add\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" /><br />\n";
		echo "Start time: <input type=\"text\" name=\"start\" /><br />\n";
		echo "End time: <input type=\"text\" name=\"end\" /><br />\n";
		require_once('lib/voc.php');
		echo "Type: <select name=\"type\">\n";
		foreach(voc('type') as $type)
			echo "<option value=\"$type\">$type</option>\n";
		echo "</select>\n";
		echo "Descryption: <br /><textarea name=\"descr\"></textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$topic['title'] = $_POST['title'];
		$topic['start'] = $_POST['start'];
		$topic['end'] = $_POST['end'];
		$topic['type'] = $_POST['type'];
		$topic['descr'] = $_POST['descr'];
		$topic['id'] = topicid($media['id']);
		$id = puttopic($topic);
		if(!$id)
			die('failure');
		header("Location: /btshow/media.php?id={$media['id']}#topic$id");
	}
}elseif($_GET['action']=='edit'){
	if(!rights('topic','edit'))
		die('no rights');
	$topic = gettopic($_GET['id']);
	$media = getmedia($topic['media']);
	if(!$topic)
		die('not found');
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "Editing topic {$topic['title']} of franchise {$media['title']}\n";
		echo "<form action=\"edittopic.php?id={$topic['id']}&action=edit\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" value=\"{$topic['title']}\"/><br />\n";
		echo "Start time: <input type=\"text\" name=\"start\" value=\"{$topic['start']}\"/><br />\n";
		echo "End time: <input type=\"text\" name=\"end\" value=\"{$topic['end']}\"/><br />\n";
		echo "Type: <select name=\"type\">\n";
		require_once('lib/voc.php');
		foreach(voc('type') as $type)
			echo "<option value=\"$type\"",($topic['type']==$type?" selected=\"selected\"":""),">$type</option>\n";
		echo "</select>\n";
		echo "Descryption: <br /><textarea name=\"descr\">{$topic['descr']}</textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$topic['id'] = $_GET['id'];
		$topic['title'] = $_POST['title'];
		$topic['start'] = $_POST['start'];
		$topic['end'] = $_POST['end'];
		$topic['type'] = $_POST['type'];
		$topic['descr'] = $_POST['descr'];
		$id = puttopic($topic);
		if(!$id)
			die('failure');
		$t=explode('/',$topic['id']);
		$mid=$t[0];
		header("Location: /btshow/media.php?id=$mid#topic$id");
	}
}elseif($_GET['action']=='delete'){
	if(!rights('topic','delete'))
		die('no rights');
	if(!gettopic($_GET['id']))
		die('not found');
	deletemedia($_GET['id']);
	header("Location: /btshow/media.php");
}elseif($_GET['action']=='undelete'){
	if(!rights('topic','undelete'))
		die('no rights');
}else{
	die('unknown action');
}
