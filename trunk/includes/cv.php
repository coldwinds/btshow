<?php

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
		$db = db::init();
		$result=$db->select('controlled_vocabulary',array('id','tagid','value'));
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
	
	public function suggest($key){
		$db=db::init();
		$db->select('entry',);
	}

	public function update_values_by_tagid($tagid,$newv){
		$oldv=search_values($tagid);
		$only_old=array_diff($oldv,$newv);
		$only_new=array_diff($newv,$oldv);
		settype($tagid,'integer');
		foreach($only_old as $v){
			$v=$this->db->escape($v);
			$this->db->query("DELETE FROM {$this->db->prefix}controlled_vocabulary WHERE tagid='$tagid' AND value='$value'");
		}
		foreach($only_new as $v){
			$v=$this->db->escape($v);
			$this->db->query("INSERT INTO {$this->db->prefix}controlled_vocabulary (tagid,value) VALUES('$tagid','$value')");
		}
	}
}


