<?php
require_once('lib/init.php');
require_once('lib/media.php');
require_once('lib/file.php');

if($_GET['action']=='add'){
	if(!rights('post','add'))
		die('no rights');
	$thread = getthread($_GET['id']);
	if(!$thread)
		die('no such topic');
	$topic = gettopic($thread['topic']);
	$media = getmedia($topic['media']);
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "<a href=\"media.php?id={$media['id']}\">{$media['title']}</a> &gt;";
		echo "<a href=\"media.php?id={$media['id']}#topic{$topic['id']}\">{$topic['title']}</a> &gt;";
		echo "<a href=\"thread.php?id={$thread['id']}\">{$thread['title']}</a> &gt;";
		echo "Create a new post\n";
		echo "<form enctype=\"multipart/form-data\" action=\"editpost.php?id={$thread['id']}&action=add\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" value=\"{$thread['title']}\"/>\n";
		echo "Part: <input type=\"text\" name=\"part\" />\n";
		$signed = explode("\n",$thread['author']);
		echo "Post as: <input type=\"checkbox\" name=\"author[]\" value=\"{$user['id']}\" ";
		if(in_array($user['id'], $signed))echo "checked=\"checked\"";
		echo "/> {$user['name']}\t";
		foreach(explode("\n",$user['sign']) as $sign){
			$u = getuser($sign);
			echo "<input type=\"checkbox\" name=\"author[]\" value=\"{$u['id']}\" ";
			if(in_array($u['id'], $signed))echo "checked=\"checked\"";
			echo "/> {$u['name']}\t";
		}
		echo "\n";
		echo "Description: <input type=\"text\" name=\"descr\" />\n";
		echo "Torrent: <input type=\"file\" name=\"upload\" />\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$post['title'] = $_POST['title'];
		$post['type'] = $topic['type'];
		$post['descr'] = $_POST['descr'];
		if(!$_POST['author'])
			die('wrong sign');
		$post['author'] = implode("\n",$_POST['author']);
		if(!rights("sign", 'sign', $post['author']))
			die('wrong sign');
		$post['part'] = $_POST['part'];
		$t=putfile($_FILES['upload']);
		if(!$t)
			die('torrent error');
		$post['size'] = $t['size'];
		$post['infohash'] = $t['infohash'];
		$post['date'] = date('r');
		$post['id'] = postid($thread['id']);
		$id = putpost($post);
		if(!$id)
			die('failure');
		header("Location: /btshow/thread.php?id={$thread['id']}");
	}
}elseif($_GET['action']=='edit'){
	$post = getpost($_GET['id']);
	if(!$post)
		die('not found');
	if(!rights('post','edit',$post['author']))
		die('no rights');
	$thread = getthread($post['thread']);
	$topic = gettopic($thread['topic']);
	$media = getmedia($topic['media']);
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "<a href=\"media.php?id={$media['id']}\">{$media['title']}</a> &gt;";
		echo "<a href=\"media.php?id={$media['id']}#topic{$topic['id']}\">{$topic['title']}</a> &gt;";
		echo "<a href=\"thread.php?id={$thread['id']}\">{$thread['title']}</a> &gt;";
		echo "Editing {$post['title']}\n";
		echo "<form enctype=\"multipart/form-data\" action=\"editpost.php?id={$post['id']}&action=edit\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" value=\"{$post['title']}\"/>\n";
		echo "Part: <input type=\"text\" name=\"part\" value=\"{$post['part']}\"/>\n";
		$signed = explode("\n",$post['author']);
		echo "Post as: <input type=\"checkbox\" name=\"author[]\" value=\"{$user['id']}\" ";
		if(in_array($user['id'], $signed))echo "checked=\"checked\"";
		echo "/> {$user['name']}\t";
		foreach(explode("\n",$user['sign']) as $sign){
			$u = getuser($sign);
			echo "<input type=\"checkbox\" name=\"author[]\" value=\"{$u['id']}\" ";
			if(in_array($u['id'], $signed))echo "checked=\"checked\"";
			echo "/> {$u['name']}\t";
		}
		echo "\n";
		echo "Description: <input type=\"text\" name=\"descr\" value=\"{$post['descr']}\"/>\n";
		echo "Torrent: <input type=\"file\" name=\"upload\" />\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$post['title'] = $_POST['title'];
		$post['type'] = $topic['type'];
		$post['descr'] = $_POST['descr'];
		if(!$_POST['author'])
			die('wrong sign');
		$post['author'] = implode("\n",$_POST['author']);
		if(!rights("sign", 'sign', $post['author']))
			die('wrong sign');
		$post['part'] = $_POST['part'];
		if($_FILES['upload']['error']!=UPLOAD_ERR_NO_FILE){
			$t=putfile();
			if(!$t)
				die('torrent error');
			$post['size'] = $t['size'];
			$post['infohash'] = $t['infohash'];
		}
		$post['date'] = date('r');
		$id = putpost($post);
		if(!$id)
			die('failure');
		header("Location: /btshow/thread.php?id={$thread['id']}");
	}
}elseif($_GET['action']=='delete'){
	$post = getpost($_GET['id']);
	if(!$post)
		die('not found');
	$thread = getthread($post['thread']);
	if(!rights('post','delete',$post['author']))
		die('no rights');
	if(!deletepost($_GET['id']))
		die('failure');
	header("Location: /btshow/thread.php?id={$thread['id']}");
}elseif($_GET['action']=='undelete'){
	$post = getpost($_GET['id']);
	if(!$post)
		die('not found');
	$thread = getthread($post['thread']);
	if(!rights('post','undelete',$post['author']))
		die('no rights');
	undeletepost($_GET['id']);
	header("Location: /btshow/thread.php?id={$thread['id']}");
}else{
	die('unknown action');
}
