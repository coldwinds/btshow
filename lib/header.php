<?php
require_once('lib/auth.php');
$start=microtime(true);
echo "<pre>\n";
echo "[站点logo]                      <a href=\"/btshow\">主页</a> [新闻网] ";
if($user['name']){
	echo "欢迎登录 ";
	echo "<a href=\"user.php\">{$user['name']}</a> ";
	echo "<a href=\"logout.php\">登出</a>\n";
}else{
	echo "<a href=\"login.php\">登录 / 注册</a>\n";
}

echo "导航: <a href=\"media.php\">media list</a>\n";
function now(){return microtime(true)*1000;}
?>
