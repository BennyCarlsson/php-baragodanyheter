<?php

Class AllUsersObject{
	public $userId;
	public $mail;
	public $firstname;
	public $lastname;
	public $role;
	public $regDate;
	
	public function __construct($UserId, $Mail, $Firstname, $Lastname, $Role, $RegDate){
		$this->userId = $UserId;
		$this->mail = $Mail;
		$this->firstname = $Firstname;
		$this->lastname = $Lastname;
		$this->role = $Role;
		$this->regDate = $RegDate;
	}
}
