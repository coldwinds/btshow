<?php

class entry{
	public $tags;
	public $delete;
	public $modify;
	
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
	private static function import_db($result){
		if(false===$result)
			return $result;
		$entries=array();
		foreach($result as $row){
			$entries[0+$row['id']]=new entry;
			foreach($row as $col=>$value){
				$entries[0+$row['id']]->tags[$col]->value=$value;//assume the colname is the tagname
			}
		}
		return $entries;
	}
	
	private function assign(tag $tag){
		$this->tags[$tag->id]=$tag;
		$this->tags[$tag->name]=&$this->tags[$tag->id];
	}

	public function __construct(){
		global $sg_tags_definition;
		$this->tags=array();
		foreach($sg_tags_definition as $id=>$tagattr){
			$this->assign(new tag($id));
		}
		$this->modify=user::judge('page-modify',$this->tagval('owner'),$this->tagval('owningteam'));
		$this->delete=user::judge('page-delete',$this->tagval('owner'),$this->tagval('owningteam'));
	}
	public function tagval($tagname){
		return $this->tags[$tagname]->value;
	}
	public static function import_post(){
		$e=new entry;
		foreach($_POST as $key=>$value){
			$t=new tag($key);
			if($t->id&&$t->input){
				$t->import(urldecode($value));
				if(!$t->empty())
					$e->assign($t);
			}
		}
		return $e;
	}
	
	public static function recent($conds){
		$db=db::init();
		$where=array();
		foreach($conds['tags'] as $tid=>$cond){
			if(0+$tid){
				$where[0+$tid]=$db->escape($cond);
			}
		}
		if(0+$conds['limit'])
			$limit=0+$conds['limit'];
		$limit=min($limit,500);
		$where=implode(',',$where);
		strlen($where) && $where="WHERE $where";
		$result=$db->query("SELECT * FROM {$db->prefix}entry $where LIMIT $limit");
		return self::import_db($result);
	}
	
	public static function load($entry_id){
		$db=db::init();
		$entry_id=0+$entry_id;
		$result=$db->query("SELECT * FROM {$db->prefix}entry WHERE id=?",$entry_id);
		$entries=import_db($result);
		return array_pop($entries);
	}
	
	public function match($limit){
		$db=db::init();
		
	}

	public static function quicksearch($keys,$limit){
		global $sg_quicksearch_max_key_num;
		$db=db::init();
		$pn=new tag('part_number');

		/* do not use too many keys! */
		$keys=array_slice($keys,0,$sg_quicksearch_max_key_num);

		/* 
		  convert keys into controlled keys as many as possible
		*/
		$controlled_keys=array();
		foreach($keys as $n=>$key){
			if(is_numeric($key)){
				//special handling on part_number
				//directly converted into a controlled value
				$controlled_keys[$pn->id]=0+$key;
				continue;
			}
			$no_tagid_dup='';
			if(count($controlled_keys)){
				//no double search on the same tag
				//so only the first value of the same tag remains
				//the rest are leaved for fulltext search
				$no_tagid_dup='tag_id NOT IN('.implode(',',array_keys($controlled_keys)).') AND ';
			}
			$result=$db->query("SELECT * FROM {$db->prefix}controlled_vocabulary WHERE {$no_tagid_dup}MATCH(aliases) AGAINST(?)",$key);
			if(count($result)==0){
				//not convertible, leave it for fulltext keywords search
			}else{
				foreach($result as $row){
					$controlled_keys[0+$row['tag_id']]=0+$row['cv_id'];
				}
				unset($key);
			}
		}
		//now remaining elements in $keys are for fulltext search
		$where=array();
		foreach($controlled_keys as $tagid=>$cvid){
			$t=new tag($tagid);
			$where[]=$t->name."='$cvid'";
		}
		foreach($keys as $key){
			$t=$db->escape($key);
			$where[]="MATCH(keywords) AGAINST('$key')";
		}
		$where=implode(' AND ',$where);
		
		/* main query here! */
		$result=$db->query("SELECT * FROM {$db->prefix}entry $where LIMIT ?",$limit);
		return self::import_db($result);
	}
	
	public function insert(){
		$db=db::init();
		$this->trim();
		$cols=implode(',',$this->tagnames());
		$vals=implode(',',$this->tagvalues());
		$result=$db->query("INSERT INTO {$db->prefix}entry ($cols) VALUES($vals)");
		if(false===$result)
			return false;
		if(!$db->affected_rows)
			return false;
		return $db->insert_id;
	}
	
	public function update(){
		$db=db::init();
		$this->trim();
		$cols=$this->tagnames();
		$vals=$this->tagvalues();
		$sets=array();
		for($i=0;$i<count($cols);$i++){
			$sets[]=$cols[$i]."='".$db->escape($vals[$i])."'";
		}
		$sets=implode(',',$sets);
		$db->query("LOCK TABLES {$db->prefix}entry WRITE");
		$result=$db->query("UPDATE {$db->prefix}entry SET $sets WHERE id='{$this->tags[tag::$name2id['id']]->value}'");
		$db->query("UNLOCK TABLES");
		if(false===$result)
			return false;
		return $db->affected_rows;
	}
/*	
	public function purge(){
		$db=db::init();
		$result=$db->delete("entry","id='{$tags[tag::$name2id['id']]->value}'");
		return $result;
	}
*/
}

