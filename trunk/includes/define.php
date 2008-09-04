<?php
if(!defined('BTSHOW'))

define('BTSHOW_NAME','btshow');
define('BTSHOW_VERSION','0.0.0');
$sg_btshow_fullname = BTSHOW_NAME . ' ' . BTSHOW_VERSION;

define('DB_FETCH_ROW',1);
define('DB_FETCH_COL',2);
define('DB_FETCH_BOTH',3);

$sg_defined_actions=array(
	'', // html viewable
	'detail', // html viewable
	'meta', // html viewable
	'edit', // html viewable
	'get',
	'rss',
	'ajax',
	'api',
	'user', // html viewable
	'stats', // html viewable
	'help', // html viewable
);
$sg_defined_rssable_tags=array(
	'type',
	'genre',
	'topic',
	'title',
	'republisher',
	'translator',
	'format',
);
