<?php
function view_post($id){
	require_once('lib/thread.php');
	view_thread($id);
}
function takepost_post(){
}
function postform_post(){
}
function summary_post($id ,$post = false){
	if(!$post)
		$post = getobject($id);
	foreach($thread['contents']['author'] as $author){
		$user = getobject("user/$author");
		if(!judge('user','view',$user['rights']))
			continue;
		$authors[] = "<a href=\"index.php?id=user/$author\">{$user['contents']['name']}</a>";
	}
	return array(
	implode(' &amp; ',$authors),
	date('m-d',$post['contents']['date']));
	
	
}
function summaryheader_post(){
}
