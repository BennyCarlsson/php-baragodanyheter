<?php
require_once 'adminDAL.php';
require_once 'userPage/model/hashAndSalt.php';

Class RegisterModel{
	private $hashAndSalt;
	private $adminDAL;
	public $messageNR = array();
	const maxLength = 45;
	const minPassLength = 5;
	const defaultRoleId = 2; //journalist
	
	public function __construct(){
		$this->hashAndSalt = new HashAndSalt();
		$this->DAL = new AdminDAL();
	}
	
	public function register($mail, $password, $password2, $firstname, $lastname){
		if($this->regCheck($mail, $password, $password2, $firstname, $lastname)){
			$salt = $this->getSalt();
			$hashedPass = $this->getHashedPass($password, $salt);
			$this->DAL->addUser($mail, $hashedPass, $salt, $firstname, $lastname, self::defaultRoleId);
			$this->addMessageNR(9);
		}else{
			$this->addMessageNR(8);	
		}
	}
	public function getSalt(){
		return $this->hashAndSalt->GetSalt();
	}
	public function getHashedPass($password, $salt){
		return $this->hashAndSalt->getHashedPassword($password, $salt);
	}
	private function regCheck($mail,$password,$password2,$firstname,$lastname){
		$check = TRUE;
		if($this->checkPasswords($password, $password2) == FALSE){
			$check = FALSE;
		}
		if($this->checkMail($mail) == FALSE || $this->checkMailExist($mail) == FALSE){
			$check = FALSE;
		}
		if($this->checkName($firstname, $lastname) == FALSE){
			$check = FALSE;
		}
		return $check;
	}
	public function doEditUserCheck($firstname,$lastname,$mail, $userId){
		$check = TRUE;
		if($this->DAL->checkIfChangingMail($mail, $userId)){//check if changing his mail
			if($this->checkMailExist($mail) == FALSE){ //if changing mail check if mail already exist!
				$check = FALSE;
			}
		}
		if($this->checkMail($mail) == FALSE){
				$check = FALSE;
		}
		if($this->checkName($firstname, $lastname) == FALSE){
			$check = FALSE;
		}
		return $check;
	}
	private function checkName($firstname, $lastname){
		$check = TRUE;
		if(empty($firstname) || empty($lastname)){
			$check = FALSE;
			$this->addMessageNR(1);
		}
		if($firstname > self::maxLength || $lastname > self::maxLength){
			$check = FALSE;
			$this->addMessageNR(5);
		}
		if($this->stripInput($firstname)||$this->stripInput($lastname)){
			$check = FALSE;
			$this->addMessageNR(7);
		}
		return $check;
	}
	private function checkMailExist($mail){
		if($this->DAL->checkIfMailExist($mail)){
			$this->addMessageNR(6);
			return FALSE;
		}
		return TRUE;
	}
	private function checkMail($mail){
		$check = TRUE;
		if(empty($mail)){
			$check = FALSE;
			$this->addMessageNR(1);
		}
		if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
			$check = FALSE;
			$this->addMessageNR(4);
		}
		if($mail > self::maxLength){
			$check = FALSE;
			$this->addMessageNR(5);
		}
		if($this->stripInput($mail)){
			$check = FALSE;
			$this->addMessageNR(7);
		}
		return $check;
	}
	
	public function checkPasswords($password, $password2){
		$check = TRUE;
		if(empty($password) || empty($password2)){
			$check = FALSE;
			$this->addMessageNR(1);
		}
		if($password != $password2){
			$check = FALSE;
			$this->addMessageNR(2);
		}
		if(strlen($password) < self::minPassLength){
			$check = FALSE;
			$this->addMessageNR(3);
		}
		if($password > self::maxLength){
			$check = FALSE;
			$this->addMessageNR(5);
		}
		if($this->stripInput($password)){
			$check = FALSE;
			$this->addMessageNR(7);
		}
		return $check;
	}
	
	private function stripInput($input){
		$strippedInput = strip_tags($input);
		if($input === $strippedInput){
			return FALSE;
		}
		return TRUE;
	}
	
	private function addMessageNR($nr){
		$this->messageNR[] = $nr;
	}
}
