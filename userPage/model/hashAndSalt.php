<?php

Class HashAndSalt{
	const saltSize = 10;
	
	public function GetSalt(){
		$salt = mcrypt_create_iv(self::saltSize, MCRYPT_DEV_RANDOM);
		return base64_encode($salt);
	}
	public function getHashedPassword($password, $salt){
		$hashedPass = crypt($password, $salt); 
		return $hashedPass;
	}
}
