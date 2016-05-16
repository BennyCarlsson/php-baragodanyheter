<?php

Class UserObject{
	public $id;
	public $_mail;
	public $firstname;
	public $lastname;
	public $isAdmin = false;  //bool
	const adminRoleId = 1;
	const journalistRoleId = 2;
	const frozenRoleId = 3;
	public $userRole;
	
	public function __construct($id, $mail, $firstname, $lastname, $roleId){
		$this->id = $id;
		$this->_mail = $mail;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->userRole = $roleId;
		
		//check if the loggedin user is admin
		if($roleId == self::adminRoleId){
			$this->isAdmin = TRUE;
		}else{
			$this->isAdmin = FALSE;
		}
	}
	
}
