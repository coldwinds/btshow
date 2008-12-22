<?php

//title, descr
function view_media($id, $media = false){
	if(!$media)
		$media = getobject($id);
	echo $media['contents']['title'], getrightsbuttons($id, $media['rights']), "\n";
	echo $media['contents']['descr'], "\n";

	$types=array();
	foreach(getchildren($id) as $id){
		$topic = getobject($id);
		$types[$topic['contents']['type']][$id] = $topic;
	}
	ksort($types);
	foreach($types as $typename=>$type){
		echo "Type: $typename\n";
		require_once("lib/topic.php");
		foreach($type as $id=>$topic){
			if(!judge('topic','view',$topic['rights']))
				continue;
			echo "\t* ",implode(" ",shortview_topic($id, $topic)),"\n";

			foreach(getchildren($id) as $threadid){
				$thread = getobject($threadid);
				if(!judge('thread','view',$thread['rights']))
					continue;
				require_once('lib/thread.php');
				echo "\t\t* ",implode(" ",shortview_thread($threadid, $thread)),"\n";
			}
		}
	}
}

function form($obj){
$type = objecttype($obj['id']);
<<<EOF
<form action="edit.php?id={$obj['id']}" method="post">
Title: <input type="text" name="title" value="{$obj['title']}"/>
Descryption: 
<textarea name="descr">{$obj['descr']}</textarea>
<input type="submit" value="submit" />
</form>
EOF;
}
function takepost(&$obj){
	
}

function shortview_media($id, $media = false){
	if(!$media)
		$media = getobject($id);
	$count = count(getchildren($id));
	return array("<a href=\"index.php?id=$id\">$title</a>"," ($count)".gerrightbuttons($id, $media['rights']));
}
function shortviewheader_media(){
	return array('title','count');
}
	
