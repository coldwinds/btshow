DROP TABLE IF EXISTS `shw_entry`;
CREATE TABLE `shw_entry` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_cv_id` int(11) unsigned default NULL,
  `genre_cv_id` int(11) unsigned default NULL,
  `title_cv_id` int(11) unsigned default NULL,
  `republisher_cv_id` int(11) unsigned default NULL,
  `translator_cv_id` int(11) unsigned default NULL,
  `artist_cv_id` int(11) unsigned default NULL,
  `contributor_cv_id` int(11) unsigned default NULL,
  `language_cv_id` int(11) unsigned default NULL,
  `subtitle_language_cv_id` int(11) unsigned default NULL,
  `origin_cv_id` int(11) unsigned default NULL,
  `format_cv_id` int(11) unsigned default NULL,
  `subtitle_format_cv_id` int(11) unsigned default NULL,
  `video_codec_cv_id` int(11) unsigned default NULL,
  `audio_codec_cv_id` int(11) unsigned default NULL,
  `software_platform_cv_id` int(11) unsigned default NULL,
  `part_number` int(11) unsigned default NULL,
  `video_height` int(11) unsigned default NULL,
  `video_width` int(11) unsigned default NULL,
  `video_bitrate` int(11) unsigned default NULL,
  `video_framerate` int(11) unsigned default NULL,
  `audio_bitrate` int(11) unsigned default NULL,
  `audio_channel` int(11) unsigned default NULL,
  `date_air` int(11) unsigned default NULL,
  `date_republish` int(11) unsigned default NULL,
  `size` bigint(20) unsigned default NULL,
  `republish_title` varchar(255) default NULL,
  `republisher_comment` text,
  `torrent_infohash` blob NOT NULL,
  `torrent_filelist` text,
  `torrent_comment` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `torrent_infohash` (`torrent_infohash`(20))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='all metadata about the torrent entry uploaded by user.';

/* XXX requiring optimization below */
DROP TABLE IF EXISTS `shw_controlled_vocabulary`;
CREATE TABLE `shw_controlled_vocabulary` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `tag_id` int(11) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/* 
SELECT * FROM shw_controlled_vocabulary WHERE id='$id';
*/
DROP TABLE IF EXISTS `shw_alias_index`;
CREATE TABLE `shw_alias_index` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `cv_id` int(11) unsigned NOT NULL,
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `cv_id` (`cv_id`,`alias`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `shw_user`;
CREATE TABLE `shw_user` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL COMMENT 'email',
  `group_id` int(11) unsigned NOT NULL,
  `role` int(11) unsigned NOT NULL default '1' COMMENT '1-user  2-confirmed  4-uploader \r\n8-teamleader  16-sysop  32-developer',
  `register_ip` int(11) unsigned NOT NULL,
  `last_login_ip` int(11) unsigned NOT NULL,
  `last_modify_time` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `create_time` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `username_password` (`username`,`password`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;