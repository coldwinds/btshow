CREATE TABLE `shw_entry` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `type_cvid` int(11) unsigned default NULL,
  `genre_cvid` int(11) unsigned default NULL,
  `title_cvid` int(11) unsigned default NULL,
  `republisher_cvid` int(11) unsigned default NULL,
  `translator_cvid` int(11) unsigned default NULL,
  `artist_cvid` int(11) unsigned default NULL,
  `contributor_cvid` int(11) unsigned default NULL,
  `language_cvid` int(11) unsigned default NULL,
  `subtitle_language_cvid` int(11) unsigned default NULL,
  `origin_cvid` int(11) unsigned default NULL,
  `format_cvid` int(11) unsigned default NULL,
  `subtitle_format_cvid` int(11) unsigned default NULL,
  `video_codec_cvid` int(11) unsigned default NULL,
  `audio_codec_cvid` int(11) unsigned default NULL,
  `software_platform_cvid` int(11) unsigned default NULL,
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
CREATE TABLE `shw_controlled_vocabulary` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`tagid` INT,
	`value` VARCHAR(255),
	PRIMARY KEY (`id`)
);
/* 
u
SELECT * FROM shw_controlled_vocabulary WHERE id='$id';

 */

CREATE TABLE shw_aliasindex (
	cvid INT,
	alias VARCHAR(255),
);

