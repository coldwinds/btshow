<?php
function localize($message_name){
	$num_args = func_num_args;
	$search = array();
	for($i=0;$i<$num_args;$i++)
		$search[] = "\$$i";
	return str_replace($search,func_get_args(),$sg_messages[$message_name]);
}
