<?php

function view_logpool($id){
	$pool = getobject($id);
	$type = objecttype($id);
	echo $pool['contents']['title'], " :", getrightsbuttons($id, $pool['rights']), "\n";
	$subtype = subtype($type);
	require_once("lib/$subtype.php");
	echo implode("\t",shortviewheader($id)),"\n";
	$children = getchildren($id);
	foreach($children as $childid){
		$child = getobject($childid);
		if(!judge('log'/* XXX */,'view',$child['rights']))
			continue;
		echo implode("\t",shortview($id)), getrightsbuttons($childid, $child['rights']);
	}
}
function takepost_logpool(){
	return false;
}

function postform_logpool(){
}
