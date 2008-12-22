<?php
require_once("lib/auth.php");
require_once("lib/thread.php");
require_once("header.php");

echo "<pre>\n";
echo "  -- Profile --\n";
echo "display name: ", $user['name'],"\n";

if(!isset($_GET['name']) || $_GET['name']===$user['login']){
	echo "login name: ", $user['login'],"\n";
	if(count($user['group']))
		echo "Your group(s): ", implode(", ", $user['group']),"\n";
	echo "Email: ", $user['name'], "\n";
	echo "  --  Your Watchlist  -- \n";
	if(!count($user['watchlist']))
		echo "(empty) ";
	foreach($user['watchlist'] as $num=>$wl){
		$thread = getthread($wl);
		echo "\t#$num ", $thread['title'];
		echo " <a href=\"editwatchlist.php?action=delete&id=$num&returnto=user.php\">[remove]</a>";
		echo " <a href=\"editwatchlist.php?action=up&id=$num&returnto=user.php\">[put up]</a>\n";
	}
	echo "<a href=\"editwatchlist.php?action=add&thread=log/newpost&returnto=user.php\">[add default]</a>\n";
}

echo "  -- Contributions --  ";

