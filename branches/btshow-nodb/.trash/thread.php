<?php
require_once("lib/init.php");
require_once("header.php");


require_once("lib/media.php");

if(!isset($_GET['id'])){
	die('which thread?');
}

$thread = getthread($_GET['id']);
if(!$thread)
	die('not found');
$topic = gettopic($thread['topic']);
$media = getmedia($topic['media']);
echo "<a href=\"media.php?id={$media['id']}\">{$media['title']}</a> &gt;";

echo "<a href=\"media.php?id={$media['id']}#{$topic['id']}\">{$topic['title']}</a> &gt;";
echo "{$thread['title']}\n";
echo "Title: {$thread['title']} ";
if(rights('thread','edit',$thread['author']))
	echo "<a href=\"editthread.php?action=edit&id={$thread['id']}\">[edit]</a>\n";

echo "Type: {$thread['type']}\n";
$authors = explode("\n",$thread['author']);
foreach($authors as &$author){
	$u = getuser($author);
	$author = "<a href=\"user.php?name=$author\">".$u['name']."</a>";
}
echo "Author(s): ",implode(" &amp; ",$authors),"\n";
echo "Description: ", $thread['descr'], "\n";

if(rights('post','add',$thread['author']))
	echo "<a href=\"editpost.php?action=add&id={$thread['id']}\">[new post]</a>\n";

echo "Posts: ",(count($thread['posts'])?"":"(none)"),"\n";
echo "date\tpart\tdescr\tsize\t???\tinfohash\n";
foreach($thread['posts'] as $postid){
	$post = getpost($postid);
	echo date('m-d',strtotime($post['date'])),"\t";
	echo $post['part'],"\t";
	echo $post['descr'],"\t";
	echo $post['size'],"\t";
	if(rights('post','edit',$post['author']))
		echo "<a href=\"editpost.php?action=edit&id={$post['id']}\">[edit]</a>\t";
	if(rights('post','delete',$post['author']))
		echo "<a href=\"editpost.php?action=delete&id={$post['id']}\">[delete]</a>\t";
	echo $post['infohash'],"\n";
}

require_once("footer.php");
