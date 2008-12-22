<?php

function getsortkey($str, $charset = 'utf8'){
	$t1 = iconv_substr($str,0,1,$charset);
	$t2 = iconv_substr($str,0,2,$charset);
	$t3 = iconv_substr($str,0,3,$charset);
	if(strlen($t1))
		$t=$t1;
	elseif(strlen($t2))
		$t=$t2;
	elseif(strlen($t3))
		$t=$t3;
	$u = iconv($charset, 'unicodebig', $t);
	
	if(ctype_digit($t))
		return '0-9';
	
	if(ctype_alpha($t))
		return strtoupper($t);

	require_once('unicode2pyinitial.php');
	$u2p = unicode2pyi($u);
	if($u2p) return $u2p;
	
	return '~';
}

function _cmp($a,$b){
	return strcmp($a['sort'], $b['sort']);
}
function alphabet($a){
	$arrange=array();
	foreach($a as $key=>$item)
		$arrange[getsortkey($item['sort'])][$key]=$item;
	ksort($arrange);
	foreach($arrange as &$val)
		uasort($val, '_cmp');
	return $arrange;
}

