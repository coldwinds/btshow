<?php
function view_userpool(){
	$userpool = getobject('user');
	echo $userpool['contents']['title'], " :",getrightsbuttons($id, $userpool['rights']),"\n";
	$children = getchildren($id);
	foreach($children as $id){
		$t = getobject($id);
		$children[$id]['sort'] = $t['contents']['title'];
	}
	require_once('lib/alphabet.php');
	$alphabet = alphabet($children);
	foreach($alphabet as $section=>$items){
		echo "-- section: $section --\n";
		foreach($items as $id=>$user){
			if(!judge(objecttype($id),'view',$user['rights']))
				continue;
			require_once('lib/user.php');
			echo implode("\t",shortview_user($id, $user)),"\n";
		}
	}
}
function takepost_userpool(){
	return false;
}
function postform_userpool(){
}
