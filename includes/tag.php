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
	private static $meta2col;
	private static $name2id;
	
	public $id;
	public $name;
	public $input;
	public $control;
	public $quantity;
	public $search;
	public $recent;
	public $detail;
	public $value;

	private function name2id($name){
		if(!isset(self::$name2id)){
			global $sg_tags_definition;
			foreach($sg_tags_definition as $id=>$attr){
				self::$name2id[$attr[0]]=$id;
			}
		}
		return self::$name2id[$name];
	}
	private function meta2col($meta){
		if(!isset(self::$meta2col)){
			self::$meta2col=array_flip(array_values(array_slice(self::$metatags,1)));
		}
		return self::$meta2col[$meta];
	}
	
	private function tag_attr($id,$attrname){
		global $sg_tags_definition;
		return $sg_tags_definition[0+$id][$this->meta2col($attrname)];
	}

	public function __construct($nameorid){
		$id=false;
		if(is_string($nameorid)){
			$id=$this->name2id($nameorid);
		}elseif(is_int($nameorid)){
			$id=$nameorid;
		}else{
			//weird happens
			user_error('tag::__construct(): wrong type specified',E_USER_WARNING);
		}
		if($id){
			$this->id=$id;
			$this->name=$this->tag_attr('name');
			$this->input=$this->tag_attr('input');
			$this->control=$this->tag_attr('control');
			$this->search=$this->tag_attr('search');
			$this->in_detail=$this->tag_attr('detail');
		}else
			$this->id=null;
	}
	public function export(){
		if($this->control){
			$cv=cv::init();
			return $cv->getval($this->value);
		}
		return $this->value;
	}
	public function import($value=''){
		if(empty($value))
			return true;
		$cv=cv::init();
		if($this->control){
			$this->value=$cv->unify($this->id,$value);
		}elseif($this->numeric){
			$this->value=0+$this->value;
		}else{
			$this->value=$value;
		}
	}
	public function options(){
		$cv=cv::init();
		return $cv->get_values_by_tag($this->id);
	}
	public function empty(){
		return empty($this->value);
	}
/*
	public static function getalltags(){
		return $alltags;
	}
	public static function gettags($confine){
		$tags=array();
		$confine_col=self::meta2col($confine);

		foreach(self::$tags_definition as $id=>$tag){
			if($tag[$confine_col])
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
*/
