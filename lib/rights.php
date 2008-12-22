<?php
function judge($obj, $action, $owner = ''){
	return true;
}
function getrights($type, $obj_rights){
	$rights=array();
	foreach($object_action as $action){
		if(judge($type, $action, $obj_rights))
			$rights[]=$action;
	}
	return $rights;
}
function getrightsbuttons($id, $obj_rights){
	$rights = getrights(object_type($id), $obj_rights);
	foreach($rights as $action)
		$actions[] = " <a href=\"index.php?id=$id&action=$action\">[$action]</a>";
	return implode("",$rights);
}
