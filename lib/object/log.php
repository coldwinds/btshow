<?php
//$log_property=array('date','action','id','editor','msg');

function action_log($action, $id){
	$obj = getobject($id);
	$type = object_type($id);
	
	if($type=='log')
		return false;
	
	$pool="log/$action/$type";
	
	$log['contents']['date'] = time();
	$log['contents']['id'] = $id;
	$log['contents']['action'] = $action;
	$log['contents']['type'] = $type;
	global $userid;
	$log['contents']['editor'] = $userid;
	
	if($action=='edit')
		$log['contents']['msg'] = $obj;
	
	putobject(newobjectid($pool), $log);
	if($obj['rights']['create'] == $userid)
		putobject(newobjectid("user/$userid/$pool"), $log);
}

function view_log($id){
	$log = getobject($id);
	echo "log: {$log['contents']['action']} a {$log['contents']['type']}", getrightsbuttons($id, $log['rights']), "\n";
	echo "date: ",date('r',$log['contents']['date'],"\n";
	echo "editor: ",$log['contents']['editor'],"\n";
	if($log['contents']['msg'])
		print_r($log['contents']['msg']);
}

function shortview_log($id){
	$log = getobject($id);
	$type = $log['contents']['type'];
	$id = $log['contents']['id'];
	$obj = getobject($id);
	require_once("lib/$type.php");
	call_user_func("shortview_$type",$id,$obj);
}
function shortviewheader_log($id){
	$log = getobject($log);
	$type = $log['contents']['type'];
	$id = $log['contents']['id'];
	$obj = getobject($id);
	require_once("lib/$type.php");
	call_user_func("shortviewheader_$type",$id,$obj);
}
function takepost_log(){
	return false;
}

function postform_log(){
}
