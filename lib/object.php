<?php


$obj_type=array('root','userpool','mediapool','media','topic','thread','post','log','logpool','user');
$obj_property=array('rights','contents');
$obj_action=array('view','create','modify','delete','undelete','top');

function object_exists($id){
	return objecttype($id) && is_dir($id);
}

function getchildren($id){
	if(!object_exists($id))
		return false;

	$dir = scandir($id);
	$children = array();
	foreach($dir as $i)
		if($i[0]!='.' && is_dir("$id/$i"))
			$children[]="$id/$i";
	return $children;
}

function getparent($id){
	if(!object_exists($id))
		return false;
	return dirname($id);
}

function getobject($id){
	if(!object_exists($id))
		return false;

	$obj = array();
	foreach($obj_property as $i)
		$obj[$i] = unserialize(@file_get_contents("$id/.$i"));

	return $obj;
}
function newobjectid($parent){
	if(!object_exists($parent))
		return false;
	$children = getchildren($parent);
	foreach($children as &$i)
		if(!is_int($i))
			unset($i);
	return "$parent/".(@max($children) + 1);
}
function putobject($id, $obj){
	$type = objecttype($id);
	if(!$type)
		return false;

	if(!object_exists($id))
		mkdir($id, 0755, true);

	foreach($obj_property as $i)
		file_put_contents("$id/.$i",serialize($obj[$i]));

	return $id;
}
/*
media/1 - media
media/1/1 - topic
media/1/1/1 - thread
media/1/1/1/1 - post

log/delete/1
log/add/thread/1
log/add/post/1
log/add/user/1
log/edit/thread/1
log/top/1

user/..../log/add
user/..../log/delete
user/..../log

*/
function subtype($type){
	if($type=='mediapool')return 'media';
	if($type=='media')return 'topic';
	if($type=='topic')return 'thread';
	if($type=='thread')return 'post';
	if($type=='userpool')return 'user';
	if($type=='logpool')return 'log';
	return false;
}

function objecttype($id){
	$id=trim($id);
	if(!strlen($id))
		return 'root';

	$t=explode('/',$id);
	$tc = count($t);

	if($t[0]=='media'){
		if($tc==1)
			return 'mediapool';
		elseif(ctype_digit($t[1])){
			if($tc==2)
				return 'media';
			elseif(ctype_digit($t[2])){
				if($tc==3)
					return 'topic';
				elseif(ctype_digit($t[3])){
					if($tc==4)
						return 'thread';
					elseif(ctype_digit($t[4])){
						if($tc==5)
							return 'post';
					}
				}
			}
		}
	}elseif($t[0]=='log'){
		if(in_array($t[1], $object_action) && in_array($t[2], $object_type)){
			if($tc==3)
				return 'logpool';
			elseif(ctype_digit($t[3])){
				if($tc==4)
					return 'log';
			}
		}
	}elseif($t[0]=='user'){
		if($tc==1)
			return 'userpool';
		elseif(ctype_alpha($t[1])){
			if($tc==2)
				return 'user';
			elseif($t[2]=='log'){
				if(in_array($t[3], $object_action) && in_array($t[4], $object_type)){
					if($tc==5)
						return 'logpool';
					elseif(ctype_digit($t[5])){
						if($tc==6)
							return 'log';
					}
				}
			}
		}
	}

	return false;
}

