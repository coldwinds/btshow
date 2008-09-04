<?php

function __autoload($class){
	require_once("./includes/$class.php");
}

if(ini_get('register_globals')){
	if(isset($_REQUEST['GLOBALS']))
		die();//$GLOBALS overwrite vulnerability
	foreach($_REQUEST as $key=>$val)
		unset($GLOBALS[$key]);
}
@ini_set('allow_url_fopen',0);

define('BTSHOW',NULL);
require_once('./includes/define.php');
require_once('./includes/local_settings.php');

$sg_exec_timer = microtime(true);

/* parse url */
$url = $_SERVER['REQUEST_URI'];
if(strlen($url)==0)
	$url = '/';

if($sg_htmlroot_path==='')
	$sg_htmlroot_path=='/';
if(strpos($sg_htmlroot_path,$url)===0)
	$url=substr($url,strlen($sg_htmlroot_path));

$e = explode('/',$url);
$sg_url_argv = array($e[1]);
for($i=2;$i<count($e);$i++)
	if(strlen($e[$i])!==0)
		$sg_url_args[]=$e[$i];
}
$sg_url_argc=count($sg_url_argv);
unset($e);
unset($url);
unset($i);


