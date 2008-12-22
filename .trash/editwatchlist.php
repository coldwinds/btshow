<?php
require_once("lib/auth.php");
if(!$user['name']){
	print("no rights");
	die();
}

if($_GET['action']=='add'){
	$wl = file("user/{$user['login']}/watchlist", FILE_IGNORE_NEW_LINES);
	array_push($wl,$_GET['thread']);
	file_put_contents("user/{$user['login']}/watchlist", implode("\n", $wl));
}elseif($_GET['action']=='delete'){
	$wl = file("user/{$user['login']}/watchlist", FILE_IGNORE_NEW_LINES);
	unset($wl[0+$_GET['id']]);
	file_put_contents("user/{$user['login']}/watchlist", implode("\n", $wl));
}elseif($_GET['action']=='up'){
	$id=0+$_GET['id'];
	if($id){
		$wl = file("user/{$user['login']}/watchlist", FILE_IGNORE_NEW_LINES);
		$t = $wl[$id-1];
		$wl[$id-1]=$wl[$id];
		$wl[$id] = $t;
		file_put_contents("user/{$user['login']}/watchlist", implode("\n", $wl));
	}
}else{
	die("unknown action");
}

header("Location: /btshow/{$_GET['returnto']}");
