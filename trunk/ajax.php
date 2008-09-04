<?php
/*
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])==='xmlhttprequest')
	http_error(501,'Not Implemented',l10n($messages['httperror-notimplemented-descr']));
*/
function errno($n){
	global $messages;
	echo json_encode('<p class="">'l10n($messages["ajax-status-$n"]));
	exit();
}
function export($s){
	echo json_encode(array('errno'=>JSON_ERRNO_SUCCESS) + $s);
	exit();
}

if(!is_set($_POST['data']))
	die();

$data=json_decode($_POST['data'],true);

$userid=user_identify();
$rights=user_rights($userid);
//from now on this user's rights table is clear.

/*
	errno:
	-1	JSON_ERRNO_UNKNOWN
	0	JSON_ERRNO_SUCCESS
	1	JSON_ERRNO_NOT_IMPLEMENTED
	2	JSON_ERRNO_INVALID_REQUEST
	3	JSON_ERRNO_NOT_AUTHORIZED
*/

if($data['action']==='post'){
	if(!is_set($rights['comment_post'])||!$rights['comment_post']) //deny by default
		errno(JSON_ERRNO_NOT_AUTHORIZED);
	
	if(!is_set($right))
	$id=comment_add($data['eid'],$userid,$data['msg'],user_ip());
	
	if($id===false)
		errno(JSON_ERRNO_INVALID_REQUEST);
	else
		export(array('cid'=>$id));
		
}elseif($data['action']==='view'){
	if(is_set($rights['comment_view'])&&!$rights['comment_view']) //allow by default
		errno(JSON_ERRNO_NOT_AUTHORIZED);
		
	$s=comment_view($data['eid'],$data['page']);
	
	if($s===false)
		errno(JSON_ERRNO_INVALID_REQUEST);
	else
		export(array('contents'=>$s));
		
}elseif($data['action']==='del'){
	if(!is_set($rights['comment_del'])||!$rights['comment_del']) //deny by default
		errno(JSON_ERRNO_NOT_AUTHORIZED);
		
	errno(comment_del($data['cid']) ? JSON_ERRNO_SUCCESS : JSON_ERRNO_INVALID_REQUEST);
	
}elseif($data['action']==='rate'){
	if(is_set($right['rate'])||!$rights['rate']) //allow by default
		errno(JSON_ERRNO_NOT_AUTHORIZED);
		
	errno(rating($data['tid'],$data['score']) ? JSON_ERRNO_SUCCESS : JSON_ERRNO_INVALID_REQUEST);
	
}else{
	errno(JSON_ERRNO_NOT_IMPLEMENTED);
}
