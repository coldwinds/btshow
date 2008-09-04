<?php
class user{
	
	/** 认证用户,判断当前请求是否已经登陆 */
	function validateUser(){
		$username = $_COOKIE['SHW_TOKEN'];
		if( strlen($username) || is_null($username)){
			//如果没有cookies，返回flase
			return false;
		}
		
		$db = db::init();
		
		return true;
	}
	
	function dologin(){
		
	}
	
	function getUserId(){
		
	}
	
	function getGroupId(){
		
	}
}
?>