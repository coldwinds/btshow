<?php
class User{
	private static $instance;

	private $userId = false;
	private $username = false;
	private $groupId = false;

	public static function getInstance(){
		if(!isset($instance)){
			$c=__CLASS__;
			self::$instance=new $c;
		}
		return self::$instance;
	}

	/** user login */
	function dologin($username,$password){
		$db = db::init();
		$sql = "select * from {$db->prefix}user where username = ? and password = ?";
		$ret = $db->queryf($sql,$username,$password);
		if($row = $ret->fetch_assoc()){
			self::$userId = $row['id'];
			self::$username = $row['username'];
			self::$userGroupId =  $row['group_id'];
			
			//TODO save token to user
			return true;
		}
		return false;
	}

	function judge($action, $object_owner_id = false, $object_owningteam_id = false){

	}

	/** invoke once when the first time visit the user propertise */
	function  __construct(){
		if(!isset($username)){
			$username = $_COOKIE['BHW_USERNAME'];
			$token = $_COOKIE['BHW_TOKEN'];
			if(isset($token) || isset($username)){// if cookie not exist

			}else{
				$db = db::init();
				$sql = "select * from {$db->prefix}user where username = ? and token = ?";
				$ret = $db->queryf($sql,$username,$token);
				if($row = $ret->fetch_assoc()){
					self::$userId = $row['id'];
					self::$userGroupId =  $row['group_id'];
					self::$username = $row['username'];
				}
			}
		}
	}

	function getUserId(){
		self::initUser();
		return self::$userId;
	}

	function getGroupId(){
		self::initUser();
		return self::$groupId;
	}
}
?>