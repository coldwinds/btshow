<?php

/* 
**IMPORTANT**

after installation, NEVER :

1) change tags' order
2) delete a line
3) add a line
4) change the `control' column

*/

class tag{
	private static $tags_definition=array(
		// 0.5 means this tag has some common values, 
		// and we can give user suggestions to minimize its possible kinds of values
		// so this kinds of tags have their controlled value in shw_cv
		//     name,                input,control,quantity,search,rssable,in_rss,in_recent,in_detail,variable
		array('',			0,	0,	0,	0,	0,	0,	0,	0,	0), //avoid id `0'
/* db key */
		array('entry_id',		0,	0,	1,	0,	0,	0,	0,	0,	0),
/* generally */
		array('type',			1,	1,	0,	1,	1,	1,	1,	1,	0),
		array('genre',			1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('topic',			1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('topic_ref',		0,	0,	0,	0,	0,	1,	0,	1,	0),
		array('title',			1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('title_ref',		0,	0,	0,	0,	0,	1,	0,	1,	0),
		array('part_number',		1,	1,	1,	1,	0,	1,	0,	1,	0),
		array('republish_title',	1,	0,	0,	1,	0,	1,	1,	1,	0),
		array('republish_title_ref',	1,	0,	0,	0,	0,	1,	1,	1,	0),
/* about people */
		array('republisher',		0,	1,	0,	1,	1,	1,	1,	1,	0),
		array('republisher_ref',	0,	0,	0,	0,	0,	1,	0,	1,	0),
		array('translator',		1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('translator_ref',		0,	0,	0,	0,	0,	1,	0,	1,	0),
		array('artist',			1,	1,	0,	1,	0,	0,	0,	1,	0),
		array('contributor',		1,	0,	0,	1,	0,	0,	0,	1,	0),
/* about date */
		array('date_air',		1,	0,	1,	1,	0,	0,	0,	1,	0),
		array('date_republish',		0,	0,	1,	1,	0,	1,	1,	1,	0),
/* about (file) contents */
		array('language',		1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('has_subtitle',		1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('subtitle_language',	1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('origin',			1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('format',			1,	1,	0,	1,	1,	1,	0,	1,	0),
		array('subtitle_format',	1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('size',			0,	0,	1,	1,	0,	1,	1,	1,	0),
		array('video_codec',		1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('audio_codec',		1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('software_platform',	1,	1,	0,	1,	0,	1,	0,	1,	0),
		array('video_height',		1,	0,	1,	1,	0,	1,	0,	1,	0),
		array('video_width',		1,	0,	1,	1,	0,	1,	0,	1,	0),
		array('video_bitrate',		1,	0,	1,	1,	0,	1,	0,	1,	0),
		array('video_framerate',	1,	0.5,	1,	1,	0,	1,	0,	1,	0),
		array('audio_bitrate',		1,	0.5,	1,	1,	0,	1,	0,	1,	0),
		array('audio_channel',		1,	0.5,	1,	1,	0,	1,	0,	1,	0),
/* torrent info */
		array('republish_comment',	1,	0,	0,	0,	0,	1,	0,	1,	0),
		array('torrent_link',		0,	0,	0,	0,	0,	1,	0,	1,	0),
		array('torrent_annouce',	0,	0,	1,	1,	0,	0,	0,	1,	0),
		array('torrent_infohash',	0,	0,	1,	1,	0,	0,	0,	1,	0),
		array('torrent_filelist',	0,	0,	0,	0,	0,	0,	0,	1,	0),
		array('torrent_comment',	0,	0,	0,	0,	0,	0,	0,	1,	0),
/* system management */
		array('owner',			0,	1,	0,	0,	0,	0,	0,	1,	0),
		array('owningteam',		0,	1,	0,	0,	0,	0,	0,	0,	0),
		array('is_starred',		1,	1,	0,	1,	1,	0,	1,	1,	0),
		array('deleted',		0,	0,	0,	0,	0,	0,	0,	0,	0),
/* frequently updated */
		array('torrent_seeders',	0,	0,	1,	0,	0,	0,	1,	1,	1),
		array('torrent_leechers',	0,	0,	1,	0,	0,	0,	1,	1,	1),
		array('torrent_complete',	0,	0,	1,	0,	0,	0,	0,	1,	1),
		array('display_order',		1,	0,	1,	0,	0,	0,	0,	0,	1),
		array('rating_score',		0,	0,	1,	0,	0,	0,	0,	1,	1),
		array('rating_times',		0,	0,	1,	0,	0,	0,	0,	1,	1),
		array('view_count',		0,	0,	1,	0,	0,	0,	0,	1,	1),
		array('download_count',		0,	0,	1,	0,	0,	0,	0,	1,	1),
		array('comment_count',		0,	0,	1,	0,	0,	0,	0,	1,	1),
	);
	private static $metatags=array('tag_id','tag_name','input','control','quantity','search','rssable','in_rss','in_recent','in_detail','variable');
	private static $meta2col;
	public static $name2id;
	public static $id2name;
	
	public $prop;
	public $value;
	public $controlled;

	public function __construct($nameorid){
		if(!isset(self::$name2id)){
			self::$name2id=array_flip(self::getallvals('tag_name'));
		}
		if(!isset(self::$id2name)){
			self::$id2name=self::getallvals('name');
		}
		if(!isset(self::$meta2col)){
			self::$meta2col=array_flip(array_values(array_slice(self::$metatags,1)));
			var_export(self::$meta2col);
		}
		$id=false;
		if(is_string($nameorid)){//strongly not recommended
			$id=self::$name2id[$nameorid];
		}elseif(is_int($nameorid)){
			$id=$nameorid;
		}else{
			//weird happens
			user_error('tag::__construct(): wrong type specified',E_USER_WARNING);
		}
		if($id)
			$this->prop=array_combine(self::$metatags,array_merge(array($id),self::$tags_definition[$id]));
		else
			$this->prop=null;
	}
	public static function getalltags(){
		$alltags=array();
		foreach(self::$tags_definition as $id=>$tag){
			$alltags[$id]=new tag($id);
		}
		return $alltags;
	}
	public static function gettags($confine){
		$tags=array();
		$confine_col=self::$meta2col[$confine];
		foreach(self::$tags_definition as $id=>$tag){
			if($tag[$confine_col]!=0)
				$tags[$id]=new tag($id);
		}
		return $tags;
	}
	public static function getallvals($type){
		$count=count(self::$tags_definition);
		$col=array_search($type,self::$metatags,true);
		$ret=array();
		if($col===false)
			return false;
		for($i=1;$i<$count;$i++){
			$v=self::$tags_definition[$i][$col];
			if($v!==0){
				$ret[$i]=$v;
			}
		}
		if(!asort($ret))
			user_error('tag::getlist() asort(): unknown error',E_USER_ERROR);
		return $ret;
	}
}
