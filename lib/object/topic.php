<?php
function view_topic($id){
	require_once('lib/media.php');
	view_media(getparent($id));
}
function shortview_topic($id, $topic = false){
	if(!$topic)
		$topic = getobject($id);
	return array(
	time()>$topic['contents']['end']?"[ended]":"[ongoing]",
	$topic['contents']['title'].getrightsbuttons($id, $topic['rights']),
	"(".date('r',$topic['contents']['start']).' - '.date('r',$topic['contents']['end']).")",
	$topic['contents']['descr']);
}
function shortviewheader_topic(){
	return array('status','title','date','descr');
}
function postform_topic(){
}
function takepost_topic(){
}
