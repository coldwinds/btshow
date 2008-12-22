<?php

function voc($t){
	$s=trim(file_get_contents("lib/define/$t"));
	if(!strlen($s))
		return array();
	return explode("\n", $s);
}
