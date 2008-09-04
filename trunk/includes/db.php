<?php
class db{
	private static $instance;
	private $db;
	private $errno;

	public static $query_times = 0;
	public $insert_id;
	public $affected_rows;
	private static $prefix;
	public static function init(){
		if(!isset($instance)){
			$c=__CLASS__;
			self::$instance=new $c;
		}
		return self::$instance;
	}
	public static function fin(){
		if(isset($instance)){
			unset($instance);
			return true;
		}
		return false;
	}
	private function __construct(){
		global $sg_db_host,$sg_db_user,$sg_db_pass,$sg_db_name,$sg_db_prefix;
		$this->prefix=$sg_db_prefix;
		$this->db = new mysqli($sg_db_host,$sg_db_user,$sg_db_pass,$sg_db_name);
		if($this->db->connect_errno)
			user_error("db connecting: ({$this->db->connect_errno}) {$this->db->connect_error}",E_USER_ERROR);
		else
			user_error("db connection: success");
		$this->errno=$this->db->connect_errno;
	}
	private function __destruct(){
		if(!$this->db->close())
			user_error("db disconnecting: ({$this->db->connect_errno}) {$this->db->connect_error}",E_USER_ERROR);
		else
			user_error("db disconnection: success");
	}

/* @return value:
	if $fetch_type is FETCH_ROW, you'll get: array(	array(colname => val1, ...), ...)
	if $fetch_type is FETCH_COL, you'll get: array(	colname => array(val1, ...), ...)
	if $fetch_type is FETCH_BOTH you'll get both.
	if errors happen, you'll get bool(false)
*/
	public function query($q,$fetch_type=DB_FETCH_ROW){
		$ret = array();
		$this->query_times++;
		$result = $this->db->query($q);
		if($this->db->errno)
			user_error("db querying: ({$this->db->errno}) {$this->db->error}",E_USER_WARNING);
		else{
			user_error("db querying: $q");
			if($fetch_type & DB_FETCH_ROW){
				while($row = $result->fetch_array(MYSQLI_ASSOC))
					$ret[] = $row;
			}
			if($fetch_type & DB_FETCH_COL){
				while($col = $result->fetch_array(MYSQLI_NUM)){
					$colname=$result->fetch_field()->name;
					$colname = "".$colname;
					$ret[$colname]=$col;
				}
			}
		}
		$this->errno=$this->db->errno;
		$this->insert_id=$this->db>insert_id;
		$this->affected_rows=$this->db->affected_rows;
		if(!$this->errno)
			return $ret;
		else
			return false;
	}
	private function wrap_table($table){
		return $this->prefix.$this->escape($table);
	}
	private function wrap_names($names){
		foreach($names as &$name){
			$name="'".$this->escape($name)."'";
		}
		return implode(',',$names);
	}
	private function wrap_where($where){
		//no escape for $where!
		//i don't know what you will give me
		if(empty($where))
			return '';
		return "WHERE ".$where;
	}
	private function wrap_sets($cols,$vals){
		$sets=array();
		foreach($cols as $k=>$col){
			$sets[]=$this->escape($cols[$k])."='".$this->escape($vals[$k])."'";
		}
		return "SET ".implode(',',$sets);
	}
	public function select($table,$cols,$where='',$options=''){
		$table=wrap_table($table);
		$cols=wrap_names($cols);
		$where=wrap_where($where);
		return $this->query("SELECT $cols FROM $table $where $options");
	}
	public function insert($table,$cols,$vals){
		$table=wrap_table($table);
		$cols=wrap_names($cols);
		$vals=wrap_names($vals);
		return $this->query("INSERT INTO $table ($cols) VALUES($vals)");
	}
	public function update($table,$cols,$vals,$where='',$lock=false){
		$table=wrap_table($table);
		$set=wrap_sets($cols,$vals);
		$where=wrap_where($where);

		if($lock){
			$this->query("LOCK TABLES $table WRITE");
		}
		$result=$this->query("UPDATE $table $set $where");
		if($lock){
			$this->query("UNLOCK TABLES;");
		}
	}
	public function delete($table,$where=''){
		$table=wrap_table($table);
		$where=wrap_where($where);
		$this->query("DELETE FROM $table $where");
	}
	public function escape($s){
		return strlen($s) ? $db->escape_string($s) : '';
	}
}
