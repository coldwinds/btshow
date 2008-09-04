<?php

class entry{
	private $tags;
	
	function __construct(){
		$tags=tag::getalltags();
	}
	
	private function tagnames(){
		$tn=array();
		foreach($this->tags as $tag){
			$tn[]=$tag->prop['name'];
		}
		return $tn;
	}
	private function trim(){
		foreach($this->tags as &$tag){
			if(strlen($tag->value)==0)unset($tag);
		}
	}
	private function tagvalues(){
		$tv=array();
		foreach($this->tags as $tag){
			$tv[]=$tag->value;
		}
		return $tv;
	}
	private static function make(&$result){
		if(false===$result)
			return $result;
		$entries=array();
		foreach($result as $row){
			$entries[0+$row['entry_id']]=new entry;
			foreach($row as $col=>$value){
				$entries[0+$row['entry_id']]->tags[tag::$name2id[$col]]->value=$value;//assume the colname is the tagname
			}
		}
		return $entries;
	}
	public static function search($conds,$options=""){
		$db=db::init();
		$result=$db->query("SELECT * FROM entry $conds $options");
		return self::make($result);
	}
	
	public static function recent($limit=500){
		$db=db::init();
		$result=$db->select('entry',array('*'),'','',$limit);
		return self::make($result);
	}

	public static function quicksearch($keys,$limit){
		global $sg_quicksearch_max_key_num;
		$db=db::init();

		/* do not use too many keys! */
		$keys=array_slice($keys,0,$sg_quicksearch_max_key_num);

		/* 
		  convert keys into controlled keys as many as possible
		*/
		$controlled_keys=array();
		foreach($keys as $n=>&$key){
			if(is_numeric($key)){
				//special handling on part_number
				//directly converted into a controlled value
				$controlled_keys[tag::$name2id['part_number']]=0+$key;
				continue;
			}
			$t=$db->escape($key);
			if(count($controlled_keys)){
				//no double search on the same tag
				//so only the first value of the same tag remains
				//the rest are leaved for fulltext search
				$no_cvid_dup="cv_id NOT IN(".implode(',',array_values($controlled_keys)).") AND ";
			}else
				$no_cvid_dup="";
			$result=$db->select('controlled_vocabulary',array('cv_id','tag_id'),"{$no_cvid_dup}MATCH(aliases) AGAINST('$t')");
			if(count($result)==0){
				//not convertible, leave it for fulltext keywords search
			}else{
				foreach($result as $row){
					$controlled_keys[]=tag::$id2name[$row['tag_id']].'='.$row['cv_id'];
				}
				unset($key);
			}
		}
		//now remaining elements in $keys are for fulltext search
		foreach($keys as &$key){
			$t=$db->escape($key);
			$key="MATCH(keywords) AGAINST('$key')";
		}
		$key_fulltext_search='';
		if(count($keys)){
			//note that here we use `AND' for simplicity
			$key_fulltext_search='('.implode(' AND ',$keys).')';
		}
		$controlled_key_exact_match='';
		if(count($controlled_keys))
			$controlled_key_exact_match='('.implode(' AND ',$controlled_keys).')';
		$middle='';
		if(count($keys)&&count($controlled_keys))
			$middle=' AND ';
		$where=$key_fulltext_search.$middle.$controlled_key_exact_match;
		
		/* main query here! */
		$result=$db->select('entry',array('*'),$where,"LIMIT $limit");
		return self::make($result);
	}
	
	public function create(){
		$db=db::init();
		$this->trim();
		$result=$db->insert("entry",$this->tagnames(),$this->tagvalues());
		return $result;
	}
	
	public function modify(){
		$db=db::init();
		$this->trim();
		$result=$db->update("entry",$this->tagnames(),$this->tagvalues(),"entry_id='{$tags[tag::$name2id['entry_id']]->value}'");
		return $result;
	}
	
	public function purge(){
		$db=db::init();
		$result=$db->delete("entry","entry_id='{$tags[tag::$name2id['entry_id']]->value}'");
		return $result;
	}
}

