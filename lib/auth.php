<?php
require_once('lib/user.php');

session_start();

$id = $_SESSION['user'];

$user['watchlist']='log/newpost';

if(user_exists($id)){
	$user = getuser($id);
}elseif($id){
	session_destroy();
	header("Location: /btshow/");
	die();
}
unset($id);

