<?php
require_once('./includes/templates/template_components.php');
class htmlpage {
	private $title;
	private $keywords;
	private $desciption;
	private $rss_title;
	private $rss_link;
	private $site_banner;
	private $site_nav;
	private $body;
	private $site_footer;
	public function setval($varname){
		
	}
	
}
function template($template_name,$params){
	if(count($params)!=extract($params))
		user_error('template exporting: some arguments are lost',E_USER_WARNING);
	ob_start();
	require_once('templates/template-'.$template_name.'.php');
	return ob_get_clean();
}

