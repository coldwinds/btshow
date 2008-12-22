<?php
$login = $_POST['login'];
$display = $_POST['display'];
$passwd = $_POST['passwd'];
$email = $_POST['email'];

if(file_exists("user/$login/name")){
	print("user exists");
	die();
}

if(!ctype_alpha($login) || strlen($login)<3){
	print("illegal login name");
	die();
}

if(strlen($display)==0)
	$display = $login;

if(strlen($passwd)<3){
	print("password too short");
	die();
}

mkdir("user/{$login}");
file_put_contents("user/$login/email", $email);
touch("user/$login/group");
file_put_contents("user/$login/name", $display);
file_put_contents("user/$login/passwd", sha1($passwd));
file_put_contents("user/$login/watchlist", "log/newpost");

session_start();
$_SESSION['user'] = $login;

header("Location: /btshow");
?>
