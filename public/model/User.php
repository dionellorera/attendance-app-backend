<?php
class User extends ActiveRecord\Model{
	public static function getToken($id){
		return User::find($id)->to_array()['token']; 
	} 
	public static function verifyToken($token){
		$conditions = array('conditions' => array("token = ?", $token));
		$record = User::first($conditions);
		$isValid = false;
		if ($record) {
			$isValid = true;
		} 
		return array('result'=>$record, 'isValid'=>$isValid);
	}
}
?>