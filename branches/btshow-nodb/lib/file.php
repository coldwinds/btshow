<?php
require_once('lib/bdecode.php');

function is_torrent($filename){
	$b = bdecode(file_get_contents($filename));
	return is_infohash($b['infohash']);
}

function is_infohash($infohash){
	return ctype_xdigit($infohash) && strlen($infohash) === 40;
}
function putfile($upload){
	if($upload['error'] != UPLOAD_ERR_OK)
		return false;

	if(!is_uploaded_file($upload['tmp_name']))
		return false;

	$b = bdecode(file_get_contents($upload['tmp_name']));
	
	if(!is_infohash($b['infohash']))	
		return false;
		
	if(!move_uploaded_file($upload['tmp_name'], fileid($b['infohash'])))
		return false;
		
	return array('size'=>$b['size'],'infohash'=>$b['infohash']);
}

function fileid($ih){
	if(!is_infohash($ih))
		return false;
	
	foreach(array("torrent/{$ih[0]}","torrent/{$ih[0]}/{$ih[1]}","torrent/{$ih[0]}/{$ih[1]}/{$ih[2]}") as $dir)
		if(!is_dir($dir))
			mkdir($dir);		
	
	return "torrent/{$ih[0]}/{$ih[1]}/{$ih[2]}/$ih.torrent";
}
