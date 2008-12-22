<?php
require_once('lib/init.php');
require_once('lib/media.php');

if($_GET['action']=='add'){
	if(!rights('thread','add'))
		die('no rights');
	$topic = gettopic($_GET['id']);
	if(!$topic)
		die('no such topic');
	$media = getmedia($topic['media']);
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "<a href=\"media.php?id={$media['id']}\">{$media['title']}</a> &gt;";
		echo "<a href=\"media.php?id={$media['id']}#topic{$topic['id']}\">{$topic['title']}</a> &gt;";
		echo "Create a new thread\n";
		echo "<form action=\"editthread.php?id={$topic['id']}&action=add\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" />\n";
		echo "Post as: <input type=\"checkbox\" name=\"author[]\" value=\"{$user['id']}\" /> {$user['name']}\t";
		foreach(explode("\n",$user['sign']) as $sign){
			$u = getuser($sign);
			echo "<input type=\"checkbox\" name=\"author[]\" value=\"{$u['id']}\" /> {$u['name']}\t";
		}

		echo "\n";
		echo "Ended: <input type=\"checkbox\" name=\"ended\" value=\"true\"/>\n";
		echo "Descryption: <textarea name=\"descr\"></textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$thread['title'] = $_POST['title'];
		$thread['ended'] = $_POST['ended'];
		$thread['type'] = $topic['type'];
		$thread['descr'] = $_POST['descr'];
		if(!$_POST['author'])
			die('wrong sign');
		$thread['author'] = implode("\n",$_POST['author']);
		if(!rights("sign", 'sign', $thread['author']))
			die('wrong sign');
		$thread['id'] = threadid($topic['id']);
		$id = putthread($thread);
		if(!$id)
			die('failure');
		header("Location: /btshow/thread.php?id={$thread['id']}");
	}
}elseif($_GET['action']=='edit'){
	$thread = getthread($_GET['id']);
	if(!$thread)
		die('not found');
	if(!rights('thread','edit',$thread['author']))
		die('no rights');
	$topic = gettopic($thread['topic']);
	$media = getmedia($topic['media']);
	if(!isset($_POST['title'])){
		require_once('header.php');
		echo "<a href=\"media.php?id={$media['id']}\">{$media['title']}</a> &gt;";
		echo "<a href=\"media.php?id={$media['id']}#topic{$topic['id']}\">{$topic['title']}</a> &gt;";
		echo "Editing thread {$thread['title']}\n";
		echo "<form action=\"editthread.php?id={$thread['id']}&action=edit\" method=\"post\">\n";
		echo "Title: <input type=\"text\" name=\"title\" value=\"{$thread['title']}\"/>\n";
		$signed = explode("\n",$thread['author']);
		echo "Post as: <input type=\"checkbox\" name=\"author[]\" value=\"{$user['id']}\"";
		if(in_array($user['id'], $signed))echo "checked=\"checked\"";
		echo "/> {$user['name']}";
		foreach(explode("\n",$user['sign']) as $sign){
			$u = getuser($sign);
			echo "<input type=\"checkbox\" name=\"author[]\" value=\"{$u['id']}\" ";
			if(in_array($u['id'], $signed))echo "checked=\"checked\"";
			echo "/> {$u['name']}\t";
		}
		echo "\n";
		echo "Ended: <input type=\"checkbox\" name=\"ended\" value=\"true\"";
		if($thread['ended'])echo "checked=\"checked\"";
		echo " />\n";
		echo "Descryption: <textarea name=\"descr\">{$thread['descr']}</textarea>\n";
		echo "<input type=\"submit\" value=\"submit\" />\n";
		echo "</form>\n";
	}else{
		$thread['title'] = $_POST['title'];
		$thread['ended'] = $_POST['ended'];
		$thread['type'] = $topic['type'];
		$thread['descr'] = $_POST['descr'];
		if(!$_POST['author'])
			die('wrong sign');
		$thread['author'] = implode("\n",$_POST['author']);
		if(!rights("sign", 'sign', $thread['author']))
			die('wrong sign');
		$id = putthread($thread);
		if(!$id)
			die('failure');
		header("Location: /btshow/thread.php?id={$thread['id']}");
	}
}elseif($_GET['action']=='delete'){
	$thread = getthread($_GET['id']);
	if(!$thread)
		die('not found');
	$topic = gettopic($thread['topic']);
	if(!rights('thread','delete',$thread['author']))
		die('no rights');
	if(!deletethread($_GET['id']))
		die('failure');
	header("Location: /btshow/media.php?id={$topic['media']}#topic".basename($topic['id']));
}elseif($_GET['action']=='undelete'){
	$thread = getthread($_GET['id']);
	if(!$thread)
		die('not found');
	$topic = gettopic($thread['topic']);
	if(!rights('thread','undelete',$thread['author']))
		die('no rights');
	if(!undeletethread($_GET['id']))
		die('failure');
	header("Location: /btshow/media.php?id={$topic['media']}#topic".basename($topic['id']));
}else{
	die('unknown action');
}
