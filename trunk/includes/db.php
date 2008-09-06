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
	function __destruct(){
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
	public function queryf($sql){
		$argv=func_get_args();
		$argc=func_num_args();
		$len=strlen($sql);
		$num=1;
		for($i=0;$i<strlen($sql)&&$num<$argc;){
			if($sql[$i]=='?'){
				$sql=substr($sql,0,$i)."'".$this->db->escape($argv[$num])."'".substr($sql,$i+1);
				$i+=strlen($argv[$num]);
				$num++;
			}else{
				$i++;
			}
		}
		return $this->db->query($sql);
	}
	public function escape($s){
		return strlen($s) ? $this->db->escape_string($s) : '';
	}
}

