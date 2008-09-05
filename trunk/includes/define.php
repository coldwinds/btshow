<?php
if(!defined('BTSHOW'))

define('BTSHOW_NAME','btshow');
define('BTSHOW_VERSION','0.0.0');
$sg_btshow_fullname = BTSHOW_NAME . ' ' . BTSHOW_VERSION;

define('DB_FETCH_ROW',1);
define('DB_FETCH_COL',2);
define('DB_FETCH_BOTH',3);


/** SCOPE */
define('SCOPE_OWN',1);
define('SCOPE_TEAM',2);
define('SCOPE_ANY',3);

/** ROLE */
define('ROLE_ANYONE',0);
define('ROLE_USER',1);
define('ROLE_CONFIRMED',2);
define('ROLE_UPLOADER',4);
define('ROLE_TEAMLEADER',8);
define('ROLE_SYSOP',16);
define('ROLE_DEVELOPER',32);


/** ACITON */
/** bussiness logic action , 1-99 */
define('PAGE_VIEW',1);
define('PAGE_CREATE',2);
define('PAGE_MODIFY',3);
define('PAGE_DELETE',4);
define('PAGE_STAR',5);
define('PAGE_RATE',6);
define('PAGE_NOCOMMENT',7);
define('COMMENT_VIEW',8);
define('COMMENT_VIEWIP',9);
define('COMMENT_POST',10);
define('COMMENT_DELETE',11);
define('CONTROLLED_VOCABULARY',12);
define('TEAM_MEMBERSHIP',13);
define('TEAM_NAME',14);
define('USER_LOGIN',15);
define('USER_RIGHTS',16);
define('USER_DELETE',17);
define('USER_SKIPCAPTCHA',201);
/** system action  , 100-199 */
define('CACHE_CLEAR',100);
define('USER_DELETE_PURGE',101);
define('PAGE_DELETE_PURGE',102);
define('COMMENT_DELETE_PURGE',103);




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

$sg_defined_rights = array();

//default rights here
$sg_defined_rights[PAGE_VIEW][ROLE_ANYONE] = SCOPE_ANY;
$sg_defined_rights[PAGE_RATE][ROLE_ANYONE] = SCOPE_ANY;
$sg_defined_rights[COMMENT_VIEW][ROLE_ANYONE] = SCOPE_ANY;
$sg_defined_rights[COMMENT_POST][ROLE_ANYONE] = SCOPE_ANY;

$sg_defined_rights[USER_LOGIN][ROLE_USER] = SCOPE_ANY;
$sg_defined_rights[USER_DELETE][ROLE_USER] = SCOPE_ANY;

$sg_defined_rights[USER_SKIPCAPTCHA][ROLE_CONFIRMED] = SCOPE_ANY;

$sg_defined_rights[PAGE_CREATE][ROLE_UPLOADER] = SCOPE_ANY;
$sg_defined_rights[PAGE_MODIFY][ROLE_UPLOADER] = SCOPE_TEAM;
$sg_defined_rights[PAGE_DELETE][ROLE_UPLOADER] = SCOPE_TEAM;
$sg_defined_rights[PAGE_NOCOMMENT][ROLE_UPLOADER] = SCOPE_OWN;

$sg_defined_rights[TEAM_MEMBERSHIP][ROLE_TEAMLEADER] = SCOPE_OWN;
$sg_defined_rights[TEAM_NAME][ROLE_TEAMLEADER] = SCOPE_OWN;

$sg_defined_rights[PAGE_MODIFY][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[PAGE_DELETE][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[PAGE_STAR][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[COMMENT_DELETE][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[COMMENT_VIEWIP][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[CONTROLLED_VOCABULARY][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[TEAM_MEMBERSHIP][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[TEAM_NAME][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[USER_RIGHTS][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[USER_DELETE][ROLE_SYSOP] = SCOPE_ANY;

$sg_defined_rights[PAGE_DELETE_PURGE][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[COMMENT_DELETE_PURGE][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[USER_DELETE_PURGE][ROLE_SYSOP] = SCOPE_ANY;
$sg_defined_rights[CACHE_CLEAR][ROLE_SYSOP] = SCOPE_ANY;


