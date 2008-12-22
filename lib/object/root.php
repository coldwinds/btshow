<?php

function view_root(){
	require_once('lib/logpool.php');
	view_logpool('log/top/post');
	global $user;
	foreach($user['contents']['watchlist'] as $id)
		view_logpool($id);
}

function takepost_root(){
	return false;
}

function postform_root(){
}
