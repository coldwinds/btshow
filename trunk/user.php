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
		$sql = "select * from {$db->prefix}user where username = ? and password = ?";
		$db = db::init();
		$ret = $db->queryf($sql,$username,$password);
		if($row = $ret->fetch_assoc()){
			self::$userId = $row['id'];
			self::$username = $row['username'];
			self::$userGroupId =  $row['group_id'];
			return true;
		}
		return false;
	}

	function judge($action, $object_owner_id = false, $object_owningteam_id = false){

	}

	/** invoke once when the first time visit the user propertise */
	private function initUser(){
		if(!isset($username)){
			$username = $_COOKIE['BHW_USERNAME'];
			$token = $_COOKIE['BHW_TOKEN'];
			if(isset($token) || isset($username)){// if cookie not exist

			}else{
				$sql = "select * from {$db->prefix}user where username = ? and token = ?";
				$db = db::init();
				$ret = $db->queryf($sql,$username,$token);
				if($row = $ret->fetch_assoc()){
					self::$userId = $row['id'];
					self::$username = $row['username'];
					self::$userGroupId =  $row['group_id'];
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