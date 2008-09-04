<?php

require_once('./includes/webstart.php');

if(!in_array($sg_url_argv[0],$sg_defined_actions)){
	header("Location: $sg_html_path/");
	die();
}

$worker = new shw($sg_url_args);

$worker->export();

