<?php
function view_thread($id, $thread = false){
	if(!$thread)
		$thread = getobject($id);
	echo $thread['contents']['title'], getrightsbuttons($id, $thread['rights']),"\n";
	echo "Type: ",$thread['contents']['type'],"\n";
	foreach($thread['contents']['author'] as $author){
		$user = getuser($author);
		if(!judge('user','view',$user['rights']))
			continue;
		$authors[] = "<a href=\"index.php?id=user/$author\">{$user['contents']['name']}</a>";
	}
	echo "Author(s): ",implode(" &amp; ",$authors),"\n";
	echo "Description: ", $thread['contents']['descr'], "\n";

	$posts = getchildren($id);
	echo "Posts: ",(count($posts)?"":"(none)"),"\n";
	require_once('lib/post.php');
	echo implode("\t",summaryheader_post()),"\n";
	foreach($posts as $id){
		$post = getobject($id);
		if(!judge('post','view',$post['rights']))
			continue;
		echo implode("\t",summary_post($id, $post)),"\n";
	}
}

function takepost_thread(){
	
	$obj['title'] = $_POST['title'];
}

function postform_thread(){
/*
<form action="editthread.php?id=<?php echo $topic['id']?>&action=add" method="post">
	Title: <input type="text" name="title" />
	Post as: <input type="checkbox" name="author[]" value="<?php echo $user['id']?>" /> <?php echo $user['name'] ?>
		foreach(explode("\n",$user['sign']) as $sign){
			$u = getuser($sign);
			echo "<input type=\"checkbox\" name=\"author[]\" value=\"{$u['id']}\" /> {$u['name']}
		}

	Ended: <input type=\"checkbox\" name=\"ended\" value=\"true\"/>
	Descryption: <textarea name=\"descr\"></textarea>
	<input type=\"submit\" value=\"submit\" />
</form>
*/
}

function summary_thread($id, $thread = false){
	if(!$thread)
		$thread = getobject($id);
	foreach($thread['contents']['author'] as $author){
		$user = getobject("user/$author");
		if(!judge('user','view',$user['rights']))
			continue;
		$authors[] = "<a href=\"index.php?id=user/$author\">{$user['contents']['name']}</a>";
	}
	return array(
	$thread['ended']?"[ended]":"[ongoing]",
	"<a href=\"index.php?id=$id\">{$thread['contents']['title']}</a>".getrightsbuttons($id, $thread['rights']),
	implode(' &amp; ',$authors),
	"(".count(getchildren($id)).")");
}

function summaryheader_thread(){
	return array('ended','title','author','count');
}
