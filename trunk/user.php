<?php
class User{
	
	public static function getInstance(){
		if(!isset($instance)){
			$c=__CLASS__;
			self::$instance=new $c;
		}
		return self::$instance;
	}


	/** user login */
	function dologin($username,$password){
		$sql = 'select * from {$db->prefix}user where username = %s and password = %s';
		$db = db::init();
		$ret = $db->queryf($sql,$username,$password);
		if($row = $ret->fetch_assoc){
			return true;
		}
		return false;
	}
	
	function judge($action, $object_owner_id = false, $object_owningteam_id = false){
		
	}

	function getUserId(){
		
	}

	function getGroupId(){

	}
}
?>