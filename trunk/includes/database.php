<?php
class db{
	private $db;
	private $errno;

	public static $query_times = 0;
	public $insert_id;
	public $affected_rows;
	public $prefix;
	function __construct(){
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
	public function escape($s){
		return is_string($s) ? $db->escape_string($s) : '';
	}
}
