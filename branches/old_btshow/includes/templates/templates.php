<?php 
//if(!defined('BTSHOW'))die('not a valid entry point'); 
//if(!function_exists('template'))die('template function not defined');


function template_html_header($title=array(),$keywords=array(),$description="",$rss=array()){
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

function template_site_banner(){
	return '<div id="site-banner"><h1>back to <a href="/">home</a></h1></div>'."\n";
}

function template_site_notice($site_notice){
	return "<div id=\"site-notice\">$site_notice</div>\n";
}

function template_comment(comment $comm){
//$id,$title,$username,$date,$body,$ip
	$class='';
	$deleted=$comm->deleted;
	$del='';
	if($deleted){
		if(!$comm->delete)return '';
		$del=template_undel_button("undeleteThisDiv()");
		$class.=' deleted';
	}elseif($comm->delete){
		$del=template_del_button("deleteThisDiv()");
	}
	$ip = $comm->viewip ? '('.$comm->ip.')' : '';
	
	$ret=<<<EOF
<div class="comment$class" id="comment-{$comm->id}">
	<p class="comment-header">{$comm->title} by {$comm->username}$ip at {$comm->date}$del</p>
	<p class="comment-body">{$comm->body}</p>
</div>

EOF;
	return $ret;
}


function template_comments_area(array $comments){
	$ret="<div id=\"comments-area\">\n";
	if(count($comments))
		foreach($comments as $comm)
			$ret.=template_comment($comm);
	else
		$ret.="\t<p class=\"error-info\">".l10n('no-comments')."</p>\n";
	$ret.="</div>\n";
	return $ret;
}
function template_post_comment(entry $entry){
	$can_comment=$entry->tagval('nocomment');
	$ret='<div id="post-comment">'."\n";
	if($can_comment){
		$ret.=<<<EOF
	<form action="$sg_url_comment" method="post">
	</form>

EOF;
	}
	$ret.="</div>\n";
	return $ret;
}

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

function template_site_nav(user $user){
	global $sg_htmlroot_path;
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

function template_infotable(array $entries,$id,$caption){
	if(!empty($table['id']))$id=" id=\"$id\"";
	$ret="<table class=\"infotable\"$id>\n";
	
	//caption
	empty($caption) && $ret.="\t<caption>$caption</caption>\n";
	
	//header
	$ret.="\t<tr>";
	foreach($entries[0]->tags as $tag){
		if($tag->recent)
			$ret.='<th>'.l10n('tag-'.$tag->name).'</th>';
	}
	$ret.="</tr>\n";
	
	//body
	$parity_count=0;
	foreach($entries as $entry){
		$class="rowparity-".($parity_count++ % 2 ? 'odd' : 'even');
		$del='';
		$mod='';
		$deleted=$entry->tagval('deleted');
		if($deleted){
			if($entry->delete){
				$del=template_undel_button("undeleteThisTr()");
				$class.=" deleted";
			}else{
				$parity_count--;
				continue; //user with no rights go away
			}
		}elseif($entry->delete){
			$del=template_del_button("deleteThisTr()");
		}
		if($entry->modify){
			global $sg_url_edit;
			$mod=template_mod_button($sg_url_edit.'/'.$entry->tagval('id'));
		}
		$class=empty($class) ? " class=\"$class\"" : "";
		$ret.="\t<tr$class>";
		foreach($entry as $tag){
			if($taag->recent){
				$col=$tag->export();
				if($tag->name=='republish_title')
					$col.=$mod.$del;
				$ret.="<td>$col</td>";
			}
		}
		$ret.="</tr>\n";
	}
	
	$ret.="</table>\n";
	return $ret;
}

function template_infobox(entry $entry){
	/* now it's 4 columns! */
	$maxcol=4;

	$table=array();
	foreach($entry as $tag){
		if($tag->detail){
			$tagid=$tag->id;
			if($entry->empty($tid)){
				$row_num=$tag->detail;
				$table[$row_num][]=$tag;
			}
		}
	}

	$class='';
	if($entry->tagval('deleted')){
		$class=' deleted';
	}

	$ret.="<table class=\"infobox$class\">\n";

	foreach($table as $row){
		$last_colspan=1+($maxcol-count($row));//note that 4 columns in total
		$ret.="\t<tr>";
		foreach($row as $col_num=>$tag){
			$colspan='';
			if($col_num==count($row)-1&&$last_colspan>1){
				$colspan=" colspan=\"$last_colspan\"";
			}
			$tagclass='';
			if($tag->control)
				$tagclass.=" controlled-tag";
			$tagname=$tag->name;
			$tagname_l10n=l10n("tag-$tagname");
			$tagvalue=$tag->export();
			if($tag->search){
				$tagname="<a href=\"$sg_url_search/$tagname:$tagvalue\">$tagname_l10n</a>";//FIXME htmlentity(), urlencode() required here
			}
			$ret.="<td$colspan><span class=\"tagname$tagclass\">$tagname</span>: $tagvalue</td>";
		}
		$ret.="</tr>\n";
	}
	$ret.="</table>\n";
	return $ret;
}

function template_editbox(entry $entry){
	global $sg_url_edit,$sg_url_edit_new;
	if($entry->tagval('id'))
		$post_action=$sg_url_edit.'/'.$entry->tagval('id');
	else
		$post_action=$sg_url_edit.'/'.$sg_url_edit_new;
	$deleted='';
	if($entry->tagval('deleted'))
		$deleted=' deleted';
	$ret="<form action=\"$post_action\" method=\"post\"><table class=\"editbox$deleted\">\n";
	$cv=cv::get_instance();
	foreach($entry a $tag){
		if($tag->input){
			$tagname=$tag->name);
			$tagid=$tag->id;
			$controlled=$tag->control;
			$value='';
	
			$ret.="\t<tr>\n";
			$ret.="\t\t<td>".l10n('tag-'.$tagname)."</td>\n";
			$ret.="\t\t<td>\n";
			if(!$tag->empty(){
				$value=" value=\"{$tag->value}\"";
			}
			if($controlled){
				$options=$tag->options();
				if(count($options)>20){
					//too many options, give autocomplete
					$ret.="\t\t\t<input type=\"text\" class=\"autocomplete\" name=\"$tagid\"$value />";
				}else{
					$ret.="\t\t\t<select name=\"$tagid\">";
					foreach($options as $opt){
						$selected='';
						if($tag->value==$opt)
							$selected=' selected="selected"';
						$ret.="\t\t\t\t<option value=\"$opt\"$selected>".$tag->export()."</option>\n";
					}
					$ret.="\t\t\t</select>\n";
				}
			}else{
				if($tagname=='republish_comment'){
					$ret.="\t\t\t<textarea name=\"$tagid\">".$tag->export()."</textarea>";
				}else{
					$ret.="\t\t\t<input type=\"text\" name=\"$tagid\"$value />";
				}
			}
			$ret.="\t\t<td>\n";
			$ret.="\t</tr>\n";
		}
	}
	$ret.="</table></form>\n";
	return $ret;
}


function template_login(){
}

function template_html_footer(){
	$ret=<<<EOF
		<div>
	</body>
</html>
EOF;
	$ret.="<!-- execution time: ".(microtime(true)-$sg_exec_timer)." second -->";
	return $ret;
}

function template_admin_button($action,$name){
	return "<span class=\"admin\"><a href=\"$action\"> ($name) </a></span>";
}

function template_del_button($action){
	return template_admin_button($action,l10n('admin-delete'));
}
function template_undel_button($action){
	return template_admin_button($action,l10n('admin-undelete'));
}function template_mod_button($action){
	return template_admin_button($action,l10n('admin-modify'));
}

function template_delete_mark($item){
	return "<span class=\"deleted\">$item</span>";
}

function template_site_footer(){
	return '<div class="site-footer"><h3>a site footer &copy; 2099 inforno theme</h3></div>'."\n";
}

