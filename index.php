<?php

require_once('./includes/webstart.php');

$worker = new shw($sg_url_args);

$worker->export();

