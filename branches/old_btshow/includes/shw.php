<?php
class shw{
	private $argv;
	private $title;
	private $keywords;
	private $description;
	private $rss;
	private $body;
		
	private function recent($limit){
		$ret='';
		if(user::judge('page-view')){
			global $sg_recent_options;
			$limit = is_numeric($arg[0]) ? $arg[0] : min($sg_recent_options);
			$limit = min($limit, max($sg_recent_options));
			$limit = max($limit, min($sg_recent_options));

			/* generate recent option navigation */
			$options=array_combine($sg_recent_options,$sg_recent_options);
			unset($options[$limit]);
			$options['']=$limit;

			/* get recently added entries here */
			$entries_list=array();

			foreach(user::profile['recent'] as $profile){
				$entries = entry::recent($profile);
				$ret.=template_body_title($profile['title']);
			}
			
			foreach($entries_tables as $list){
				$ret.=template_body_title(l10n());//"<h3>infotable's h3</h3>\n";
				$table[]=$list;
				$ret.=template_infotable($table);
			}
		}else{
			//oops, private site
			$this->body=template_site_notice('<p class="error-warning">'.l10n('norights-page-view').'</p>');
		}
		array_push($this->title,l10n('mainpage-title'));
		$ret="";
		$ret.=template_html_header($this->title,$this->keywords,$this->description,$this->rss);
		$ret.=template_site_banner();
		$ret.=template_site_nav();
		$ret.=template_site_footer();
		$ret.=template_html_footer();
		return $ret;
	}

	private function create(){
		$ret='';
		if(!user::judge('page-create'))
			//you can't create
			return template_notice_warning(l10n('page-create-norights'));
		$entry=entry::import_post();
		$entry->delete=null;
		$entry->modify=null;

		$submit_failure=false;
		if($_POST['submit']==='yes'&&$_POST['preview']!=='yes'){//submit
			if($entry_id=$entry->insert())
				redirect("$sg_url_detail/".$entry->tagval('id'));
			$submit_failure=true;
		}
		if($submit_failure||$_POST['submit']!=='yes'&&$_POST['preview']==='yes'){//preview or submit failure
			if($submit_failure)
				$ret.=template_notice_error(l10n('page-create-failure'));//template_site_notice('<p class="error-error">'.l10n('page-create-failure').'</p>');
			$ret.=template_body_title(l10n('page-preview').': '.$entry->tagval('republish_title'));
			$ret.=template_infobox($entry);
			$ret.=template_editbox($entry);
		}else{
			$ret.=template_body_title(l10n('page-create'));
			$ret.=template_editbox($entry);
		}
		return $ret;
	}
	private function modify($entry_id){
		$ret='';
		$entry=entry::load(0+$entry_id);
		$entry->delete=null;
		$entry->modify=null;
		if(!$entry->tagval('id'))
			return template_notice_error(l10n('page-modify-notfound'));

		if(!user::judge('page-modify',$entry->tagval('owner'),$entry->tagval('owningteam')))
			redirect("$sg_url_detail/".$entry->tagval('id'));

		if($entry->tagval('deleted')&&!user::judge('page-delete',$entry->tagval('owner'),$entry->tagval('owningteam')))
			return template_notice_warning('page-modify-deleted');

		$submit_failure=false;
		if($_POST['submit']==='yes'&&$_POST['preview']!=='yes'){//submit
			if($entry_id=$entry->update())
				redirect("$sg_url_detail/".$entry->tagval('id'));
			$submit_failure=true;
		}
		if($submit_failure||$_POST['submit']!=='yes'&&$_POST['preview']==='yes'){//preview or submit failure
			if($submit_failure)
				$ret.=template_notice_error(l10n('page-modify-failure'));//template_site_notice('<p class="error-error">'.l10n('page-create-failure').'</p>');
			$ret.=template_body_title(l10n('page-preview').': '.$entry->tagval('republish_title'));
			$ret.=template_infobox($entry);
			$ret.=template_editbox($entry);
		}else{
			$ret.=template_body_title(l10n('page-modify').': '.$entry->tagval('republish_title'));
			$ret.=template_editbox($entry);
		}
		return $ret;
	}

	private function delete($entry_id){
		$entry=entry::load(0+$arg);
		if(!$entry->tagval('id'))
			return template_notice_error(l10n('page-modify-notfound'));

		if(user::judge('page-delete',$entry->tagval('owner'),$entry->tagval('owningteam'))){
			$v=&$entry->tags['deleted']->value;
			$v=$v ? 0: 1;
			$entry->update();
		}
		redirect("$sg_url_detail/".$entry->tagval('id'));
	}
	
	private function detail($entry_id){
		$ret='';
		$entry=entry::load(0+$entry_id);
		if(!$entry->tagval('id'))
			return template_notice_error(l10n('page-modify-notfound'));
			
		$entry->delete=user::judge('page-delete',$entry->tagval('owner'),$entry->tagval('owningteam'));
		$entry->modify=user::judge('page-modify',$entry->tagval('owner'),$entry->tagval('owningteam'));

		if($entry->tagval('deleted')&&!$entry->delete)
			return template_notice_warning('page-modify-deleted');
		
		$ret.=template_body_title($entry->tagval('republish_title'));
		$ret.=template_infobox($entry);
		return $ret;
	}

	public function __construct(){
		global $sg_site_name,$sg_site_keywords,$sg_site_description,$sg_url_args;

		$this->argv=$sg_url_args;
		$this->title=array($sg_site_name);
		$this->keywords=array($sg_site_keywords);
		$this->description=$sg_site_description;
		//$this->rss=array('title'=>$sg_site_name,'link'=>"$sg_url/rss");
	}
	
	public function parse_args(){
		$action=$this->argv[0];
		if($action=='recent'){
			
		}
	}
	
	public function export(){
		$ret="";
		$ret.=template_html_header($title,$keywords,$description,$rss);
		$ret.=template_site_banner();
		$ret.=template_site_nav($user_nav);
		$ret.=$body;
		$ret.=template_site_footer();
		$ret.=template_html_footer();
		return $ret;
	}
}
