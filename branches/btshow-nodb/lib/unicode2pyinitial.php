<?php
function unicode2pyi($unicode){
//	$f = file_get_contents("lib/unicode2pyi.dat");
	$f = fopen('lib/unicode2pyi.dat','rb');
	$cs = /*strlen($f)/3;//*/filesize('lib/unicode2pyi.dat')/3;
	$pyi = _seeku2p($unicode, $f, 0, $cs);
	fclose($f);
	return $pyi;
}
function _u2pk(&$f, $i){
	fseek($f, $i*3);
	return fread($f, 2);
}
function _u2pv(&$f, $i){
	fseek($f, $i*3+2);
	return fread($f, 1);
}
function _seeku2p($unicode, &$f, $start, $len){
	if($len <= 0)
		return false;

	$pivot = $start + floor($len/2);
	$pivotval = /*substr($f, $pivot*3, 2);//*/_u2pk($f, $pivot);
	$left = $pivot - 1;
	$right = $pivot + 1;

	if($unicode < $pivotval)
		return _seeku2p($unicode, $f, $start, $left + 1 - $start);
	elseif($unicode > $pivotval)
		return _seeku2p($unicode, $f, $right, $len + $start - $right);
	else{
		return /*substr($f, $pivot*3+2, 1);//*/_u2pv($f, $pivot);
	}
}
?>
