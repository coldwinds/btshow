<?php 
//if(!defined('BTSHOW'))die('not a valid entry point'); 
//if(!function_exists('template'))die('template function not defined');


/*
	Template of the page header

	@arguments:
	@return: 
		(string) page header html code
*/

class html{

	function header($title=array(),$keywords=array(),$description="",$rss=array()){
		global $sg_site_lang,$sg_btshow_fullname,$sg_site_stylesheet,$sg_site_favicon,$sg_site_encoding;
		$title=implode(' - ',array_revere($title));
		$keywords=implode(',',$keywords);
		$ret=<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="$sg_site_lang" lang="$sg_site_lang" dir="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=$sg_site_encoding" />
		<meta name="generator" content="$sg_btshow_fullname" />
		<meta name="keywords" content="$keywords" />
		<meta name="description" content="$description" />
		<link rel="shortcut icon" href="$sg_site_favicon" />

EOF;
		if(count($rss)==2)$ret.=<<<EOF
		<link rel="alternate" type="application/rss+xml" title="{$rss['title']}" href="{$rss['link']}">

EOF;
		$ret.=<<<EOF
		<link rel="stylesheet" href="$sg_site_stylesheet" type="text/css" media="screen" />
		<title>$title</title>
	<body>
		<div id="global">

EOF;
	return $ret;
}

/*
	Template of the site banner

	@arguments: 
		(string) $site_banner
		[(string) $id]
	@return: 
		(string) site banner html code
*/
	function site_banner(){
	return '<div id="site-banner"><h1>back to <a href="/">home</a></h1></div>'."\n";
}


/*
	Template of the site notice (ad, or the like)
	
	@arugments:
		(string) $site_notice
		[(string) $id]
	@return:
		(string) html code of the notice
*/
function template_site_notice($site_notice){
	return "<div id=\"site-notice\">$site_notice</div>\n";
}

/*
	Template of a comment	
	
	@arguments: 
		(array(string)) $params - array(
		                        'id' => '',
		                        'title' => '',
		                        'username' => '',
		                        'date' => '',
		                        'body' => '',
		                        ['ip' => '',]
		                        ['del_button' => '',]
		                      )
	@return: 
		(string) the comment html code
*/
function template_comment($id,$title,$username,$date,$body,$ip,$type=array()){
//$del_button=" <a href=\"deleteComment('comment-$id')\">($del_button)</a>";

	$class="comment";
	if($type['deleted']){
		if($type['undelete']){
			$del="<a class=\"admin\" href=\"undeleteThisDiv()\">(".l10n('admin-undelete').")</a>";
		}else
			return ''; //user with no rights go away
		$class.=" deleted";
	}elseif($type['delete']){
		$del=" <a class=\"admin\" href=\"deleteThisDiv()\">(".l10n('admin-delete').")</a>";
	}
	
	$ip = $type['showip'] ? "($ip)" : "";
	
	$ret=<<<EOF
<div class="$class" id="comment-$id">
	<p class="comment-header">$title by $username$ip at $date$del</p>
	<p class="comment-body">$body</p>
</div>
EOF;
	return $ret;
}


/*
	Template of comments area
	
	@arguments: 
		(array(array(string))) $comments - containing what will be passed to template_comment()
		[(string) $id]
	@return:
		(string) all comments' html code together
*/
function template_comments_area($comments){
	$ret="<div id=\"comments-area\">\n";
	if(count($comments))
		foreach($comments as $comm)
			$ret.=template_comment($comm);
	else
		$ret.="\t<p class=\"error-info\">".l10n('no-comments')."</p>\n";
	$ret.=<<<EOF
</div>
<div id="post-comment">

EOF;
	return $ret;
}

/*
	Template of a kind of navigation bar

	@arguments:
		(array(mixed)) $options - array( //$href=>$name
		                           	''=>50, // '' for current page, do not generate a tag
		                           	'100'=>100,
		                           	'/get/200'=>200,
		                           	...
		                          )
	@return:
		(string) the html code of it
*/
function template_navbar($options,$id=""){
	if(!empty($id))$id=" id=\"$id\"";
	$ret="<div class=\"navbar\"$id>";
	foreach($options as $href=>$name)
		if($href!=='')
			$options[$href]="<a href=\"$href\">{$options[$href]}</a>";
		else
			$options[$href]="<span class=\"selflink\">{$options[$href]}</span>";
	$ret.=implode(" | ",$options)."</div>\n";
}

function template_site_nav(){
	global $sg_htmlroot_path;
	$user=uer::get_instance();
	if($user->gid){
		$nav=array(
			'' => l10n('user-welcome').' '.$user->name;
			"$sg_htmlroot_path/" => l10n('main-title'),
			"$sg_htmlroot_path/search" => l10n('search-title'),
			"$sg_htmlroot_path/help" => l10n('help-title'),
			"$sg_htmlroot_path/user/panel" => l10n('user-panel-title'),
			"$sg_htmlroot_path/user/logout" => l10n('user-logout-title'),
		);
	}else{
		$nav=array(
			"$sg_htmlroot_path/" => l10n('main-title'),
			"$sg_htmlroot_path/search" => l10n('search-title'),
			"$sg_htmlroot_path/help" => l10n('help-title'),
			"$sg_htmlroot_path/user/login" => l10n('user-logon-title'),
			"$sg_htmlroot_path/user/register" => l10n('user-register-title'),
		);
	}
	return template_navbar($nav,'site-nav');
}

/*
	Template of an infotable (for main page and search result)
	
	@arguments:
		(array(mixed)) $table - array(
		                        	['id'=>'',]
		                        	['caption' => '',]
		                        	'body'=>array(entry1,entry2,..)
		                           )
		[(string) $id]
	@return:
		html code of the infobox
*/
function template_infotable($table){
	$id="";
	if(!empty($table['id']))$id=" id=\"{$table['id']}\"";
	$ret="<table class=\"infotable\"$id>\n";
	
	//caption
	if(is_string($table['caption'])&&!empty($table['caption']))$ret.="\t<caption>{$table['caption']}</caption>\n";
	
	//header
	$ret.="\t<tr>";
	foreach($table['body'][0]->tags as $tag){
		$ret.='<th>'.l10n('tag-'.$tag->prop['name']).'</th>';
	}
	$ret.="</tr>\n";
	
	//body
	$parity_count=0;
	foreach($table['body'] as $entry){
		$class="rowparity-".($parity_count++ % 2 ? 'odd' : 'even');
		$del='';
		$mod='';
		if($row->tags[tag::name2id('deleted')]->value){
			if(user::judge('delete',$entry->prop['owner'],$entry->prop['owningteam'])){
				$del=template_admin_button("undeleteThisTr()",l10n('admin-undelete'));
			}else{
				$parity_count--;
				continue; //user with no rights go away
			}
			$class.=" deleted";
		}else{
			if(user::judge('delete',$entry->prop['owner'],$entry->prop['owningteam'])){
				$del=template_admin_button("deleteThisTr()",l10n('admin-delete'));
			}
		}
		if(user::judge('modify',$entry->prop['owner'],$entry->prop['owningteam'])){
			global $sg_url_edit;
			$mod=template_admin_button("$sg_url_edit/{$entry->tags[tag::name2id('id')]->value}",l10n('admin-modify'));
		}
		$class=(empty($class) ? " class=\"$class\"" : "");
		$ret.="\t<tr$class>";
		foreach($entry as $tagid=>$tag){
			$col=$tag->value;
			if($tag->prop['name']=='republish_title')
				$col.=$mod.$del;
			$ret.="<td>$col</td>";
		}
		$ret.="</tr>\n";
	}
	
	$ret.="</table>\n";
	return $ret;
}

/*
	Template of an infobox (for detail.php)
	
	@arguments:
		(array()) $info - array(
		                        	'tag' => 'value',
		                        	...
		                       )
		
*/
function template_infobox(entry $entry){
	$can_delete=user::judge('delete',$entry->tags['owner']->value,$entry->tags['owningteam']->value);
	$can_modify=user::judge('modify',$entry->tags['owner']->value,$entry->tags['owningteam']->value);
	if($entry->tags['deleted']->value){
		if($can_delete){
			$class=' deleted';
			$del=template_admin_button("undeleteThisTr()",l10n('admin-undelete'));
		}else{
			//user with no rights go away
			return '<p class="error-warning">'.l10n('norights-delete').'</p>';
		}
	}else{
		if($can_modify)
	}
	$tags=tag::gettags('in_detail');
	/* now it's 4 columns! */
	$maxcol=4;
	$table=array();
	foreach($tags as $tag){
		if(strlen($entry->tags[$tag->prop['id']])>0)
			$table[$tag->prop['in_detail']][]=$tag;
	}
	$ret.='<table class="infobox">'."\n";
	foreach($table as $row){
		$last_colspan=1+(4-count($row));//note that 4 columns in total
		$ret.="\t<tr>";
		foreach($row as $col_num=>$col){
			$ret.="<td>";
			if($col_num==count($row)-1){
				$class='';
				if($col->prop['control'])$class.=" controlled-tag";
			}
		}
	}
}

/*
	Template of  the page footer
	
	@arguments:
	@return:
		(string) html code of site footer
*/
function template_html_footer(){
	$ret=<<<EOF
		<div>
	</body>
</html>
EOF;
	$ret.="<!-- execution time: ".(microtime(true)-$sg_exec_timer)." second -->";
	return $ret;
}

/*
	Template of the administration buttons everywhere
	
	@arguments:
		(string) $action - what you want do, js_func() or other?
		(string) $name - the name displayed
	@return:
		(string) html code of the button
*/
function template_admin_button($action,$name){
	return "<span class=\"admin\"><a href=\"$action\"> ($name) </a></span>";
}

/*
	Template for marking an textual item as deleted
	
	@arguments:
		(string) $item
	@return:
		(string) html code
*/
function template_delete_mark($item){
	return "<span class=\"deleted\">$item</span>";
}

function template_site_footer(){
	return '<div class="site-footer"><h3>a site footer &copy; 2099 inforno theme</h3></div>'."\n";
}
function template_html($p,$type=array()){
	extract($p);

	$ret="";
	$ret.=template_html_header($title,$keywords,$description,$rss);
	$ret.=template_site_banner();
	$ret.=template_site_nav($user_nav);
	if($type['viewable']!==false){ //by default we want more people to view
	
		if($type['recent']){
			$ret.=template_site_notice($site_notice);
			$ret.=template_navbar($options);
			$ret.=template_infotable($recent);

		}elseif($type['detail']){
			$ret.=template_infobox($detail);
			$ret.=template_comments_area($comments);
			
		}elseif($type['meta']){
			$ret.=template_searchbox($is_meta);
			if(is_array($seach_result))
				$ret.=template_infotable($search_result);

		}elseif($type['edit']){
			$ret.=template_editbox($editbox);
		}elseif($type['user']){
			$ret.=template_userpanel($userpanel);
		}elseif($type['stats']){
			$ret.=template_infobox($stats);
		}elseif($type['help']){
			$ret.=template_help();
		}
	}else{
		$ret.=template_site_notice('<p class="error-error">'.l10n('norights-page-view').'</p>');
	}

	$ret.=template_site_footer();
	$ret.=template_html_footer();
	return $ret;
}

