<?php

class btshow{

	private $user;

	private $title;
	private $keywords;
	private $description;
	private $rss;
	private $url_args;
	
	private function rssablize($url_args){
	}
	
	private function recent(){
		if(user::judge('page-view'))){
			$limit = is_numeric($arg[0]) ? $arg[0] : min($sg_recent_options);
			$limit = min($limit, max($sg_recent_options));
			$limit = max($limit, min($sg_recent_options));

			/* generate recent option navigation */
			$options=array_combine($sg_recent_options,$sg_recent_options);
			unset($options[$limit]);
			$options['']=$limit;

			/* get recently added entries here */
			$entries = entry::recent($limit);

		}else{
			//oops, private site
			//db disconnect
			db::fin();
		}
		array_push($this->title,l10n('mainpage-title'));
	}

	function __construct($args){
		global $sg_site_name,$sg_site_keywords,$sg_site_description,$sg_db_host,$sg_db_user,$sg_db_pass,$sg_db_name;

		$this->args=$args;
		$this->title=array($sg_site_name);
		$this->keywords=array($sg_site_keywords);
		$this->description=$sg_site_description;
		$action=$sg_url_args[0];
		if($action=='recent'){
			
		}
	}
}
