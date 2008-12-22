<?php
if(!file_exists("user/{$_POST['user']}/name")){
	print("no such user");
	die();
}

if(trim(file_get_contents("user/{$_POST['user']}/passwd")) !== sha1($_POST['passwd'])){
	print("passwd wrong");
	die();
}

session_start();
$_SESSION['user'] = $_POST['user'];

header("Location: /btshow");
?>
