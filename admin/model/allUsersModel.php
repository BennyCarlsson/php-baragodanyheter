<?php
require_once 'adminDAL.php';
require_once 'allUsersObject.php';
require_once 'registerModel.php';

Class AllUsersModel{
	private $adminDAL;
	private $allUsersObject;
	private $registerModel;
	
	
	public function __construct(){
		$this->adminDAL = new AdminDAL();
		$this->registerModel = new RegisterModel();
	}	
	
	public function getAllUsers(){
		return  $this->allUsersObject = $this->adminDAL->getAllUsers();
	}
	
	public function changeNewPassword($password, $password2, $userId){
		if($this->registerModel->checkPasswords($password, $password2)){
			$salt = $this->registerModel->getSalt();
			$hashedPassword = $this->registerModel->getHashedPass($password, $salt);
			$this->adminDAL->changePassword($hashedPassword,$salt, $userId);
		}
	}
	public function editUser($firstname, $lastname, $mail, $role, $userId){
		
		if($this->registerModel->doEditUserCheck($firstname, $lastname, $mail, $userId)){
			$this->adminDAL->editUser($firstname,$lastname,$mail,$role,$userId);
		}
	}
	public function getMessageNr(){
		return $this->registerModel->messageNR;
	}
}
