<?php
function view_mediapool(){
	$mediapool = getobject('media');
	echo $mediapool['contents']['title'], " :",getrightsbuttons($id, $mediapool['rights']),"\n";
	$children = getchildren($id);
	foreach($children as &$id){
		$t = getobject($id);
		$children[$id]['sort'] = $t['contents']['title'];
		unset($id);
	}
	require_once('lib/alphabet.php');
	$alphabet = alphabet($children);
	foreach($alphabet as $section=>$items){
		echo "-- section: $section --\n";
		foreach($items as $id=>$media){
			if(!judge(objecttype($id),'view',$media['rights']))
				continue;
			require_once('lib/media.php');
			echo implode("\t",shortview_media($id, $media)),"\n";
		}
	}
}

function takepost(){
	return false;
}

function postform(){
}
