<?php
require_once('lib/init.php');
require_once('lib/media.php');

if(!$user['upload'])
	die('no rights');

if($_GET['action']=='add'){
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
}elseif($_GET['action']=='edit'){
	$media = getmedia($_GET['id']);
	if(!$media)
		die('not found');
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "Editing {$media['title']}\n";
		echo "<form action=\"editmedia.php?id={$_GET['id']}&action=edit\" method=\"post\">\n";
		echo "Title: <input type=\"text\" value=\"{$media['title']}\" name=\"title\" /><br />\n";
		echo "Descryption: <br /><textarea name=\"descr\">{$media['descr']}</textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$media['id'] = $_GET['id'];
		$media['title'] = $_POST['title'];
		$media['descr'] = $_POST['descr'];
		$id=putmedia($media);
		if(!$id)
			die('failure');
		header("Location: /btshow/media.php?id={$media['id']}");
	}
}elseif($_GET['action']=='delete'){
	if(!getmedia($_GET['id']))
		die('not found');
	$id=deletemedia($_GET['id']);
	if(!$id)
		die('failure');
	header("Location: /btshow/media.php");
}elseif($_GET['action']=='undelete'){
}else{
	die('unknown action');
}
