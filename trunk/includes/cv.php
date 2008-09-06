<?php

require_once('db.php');
class cv{
	private static $instance;
	private static $cvid2value;
	private static $cvid2tagid;
	private static $tagid2values;
	public static function init(){
		if(!isset($instance)){
			$c=__CLASS__;
			self::$instance=new $c;
		}
		return self::$instance;
	}
	private function __construct(){
		$isset=0;
		$db = db::get_instance();
		$result=$db->queryf("SELECT * FROM {$db->prefix}controlled_vocabulary");
		$this->cvid2value=array(0=>'');
		$this->cvid2tagid=array(0=>0);
		$this->tagid2values=array(0=>'');
		foreach($result as $row){
			$this->cvid2value[0+$row['id']]=$row['value'];
			$this->cvid2tagid[0+$row['id']]=$row['tagid'];
			$this->tagid2values[0+$row['tagid']][]=$row['value'];
		}
	}
//globally heavy usage, serious optimization required
 	public function getval($id){
		return $this->cvid2value[0+$id];
	}
	public function gettag($id){
		return $this->cvid2tagid[0+$id];
	}
	public function get_values_by_tag($tagid){
		return self::$tagid2values[0+$tagid];
	}
/*
	public function search_tagids($value){
		$value=$this->db->escape($value);
		$result=$this->db->query("SELECT tagid FROM {$this->db->prefix}controlled_vocabulary WHERE value='$value'");
		return array_values($result);
	}*/
	public function search_values($tagid){
		return $this->tagid2values[$tagid];
/* benchmarking for this method later
		settype($tagid,'integer');
		$result=$this->db->query("SELECT value FROM {$this->db->prefix}controlled_vocabulary WHERE tagid='$tagid'");
		return array_values($result);*/
	}
	
	public function suggest($key,$tagid=''){
		$db=db::get_instance();
		$key="%$key%";
		$result=$db->query("SELECT tag_id,tag_value FROM {$db->prefix}controlled_vocabulary WHERE aliases LIKE ?",$key);
		return $result;
	}
	public function unify($tagid,$key){
		$db=db::get_instance();
		$key="%$key%";
		$tagid=0+$tag_id;
		$result=$db->query("SELECT id FROM {$db->prefix}controlled_vocabulary WHERE tag_id=? AND aliases LIKE ?",$tagid,$key);
		return $result[0]['id'];
	}
/*
	public function update_values_by_tagid($tagid,$newv){
		$db=db::get_instance();
		$oldv=search_values($tagid);
		$only_old=array_diff($oldv,$newv);
		$only_new=array_diff($newv,$oldv);
		$tagid=0+$tagid;
		foreach($only_old as $v){
			$db->query("DELETE FROM {$db->prefix}controlled_vocabulary WHERE tagid=? AND value=?",$tagid,$value);
		}
		foreach($only_new as $v){
			$db->query("INSERT INTO {$db->prefix}controlled_vocabulary (tagid,value) VALUES(?,?)",$tagid,$value);
		}
	}*/
	public function update($cvid,$tagid,$tagvalue,$aliases){
		$tagid=0+$tagid;
		$db=db::get_instance();
		$db->query("LOCK TABLES {$db->prefix}controlled_vocabulary WRITE");
		$result=$db->query("UPDATE {$db->prefix}controlled_vocabulary SET tag_id=?, tag_value=?, aliases=? WHERE id=?",$tagid,$tagvalue,$aliases,$cvid);
		$db->query("UNLOCK TABLES");
		return $result;
	}
	
	public function delete($cvid){
	}

	public function add($tagid,$tagvalue,$aliases){
		$db=db::get_instance();
		
	}
}


