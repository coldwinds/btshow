<?php
function comment_add($eid,$userid,$msg,$ip){
	global $db;
	$userid=settype($userid,'integer');
//$username secured
	$eid=settype($eid,'integer');
//$eid secured
	$msg=$db->escape($msg);
	$msg=substr($msg,0,65500);
//$msg secured
	$result=$db->query("INSERT INTO {$db->prefix}comments (entry_id,user_id,msg,ip) VALUES('$eid','$username','$msg')");
	return ($db->affected_rows===0) ? false : $result;
}

function comment_view($eid,$page){
	global $db,$sg_comment_per_page,$sg_comment_order;
	$eid=settype($eid,'integer');
//$eid secured
	$page=settype($page,'integer');
//$page secured
	$limit=settype($page * $sg_comment_per_page,'integer');
	$result=$db->query("SELECT id,user_id FROM {$db->prefix}comments WHERE entry_id='{$eid}' ORDER BY date $sg_comment_order LIMIT $limit",DB_FETCH_COL);
}
