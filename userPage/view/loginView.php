<?php

Class LoginView{
	private $errorList = '';
	private static $mail = 'mail';
	private static $password = 'password';
	private static $loginButton = 'loginButton';
	
	public function __construct($loginModel){
		$this->loginModel = $loginModel;
	}
	public function checkLoginButton(){
		if(isset($_POST[self::$loginButton])){
			return TRUE;
		}
		return FALSE;
	}
	public function getMail(){
		return $_POST[self::$mail];
	}
	
	public function getPassword(){
		return $_POST[self::$password];
	}
	public function viewCheck(){
		if(empty($_POST[self::$mail]) || empty($_POST[self::$password])){
			$this->addError(2);
			return FALSE;
		}
		return TRUE;
	}
	public function getLoginHTML(){
		$this->getModelError();
		$mail ="";
		if(isset($_POST[self::$mail])){
			$mail = $_POST[self::$mail];
		}
		
		$HTML = "
			<div id='loginForm'>
			<h2>Logga In!</h2>
				<div id='errorMessage'><ul>".$this->errorList."</div>
				<form id='loginForm' method='post' role='form'>
					<div class='form-group'>
    					<label for='".self::$mail."'>Mail: </label>
						<input type='text' class='form-control' value='$mail' name=".self::$mail." id='mailForm'>
					</div>
					<div class='form-group'>
    					<label for='".self::$password."'>Password: </label>
						<input type='password' class='form-control' name=".self::$password." id='passwordForm'>
					</div>
					<input type='submit'  class='btn btn-default' name='".self::$loginButton."' id='loginButton'>
				</form>
			</div>
		";
		
		return $HTML;
	}
	private function getModelError(){
		$messageArray = $this->loginModel->messageNR;
		foreach ($messageArray as $i) {
			$this->addError($i);
		}
	}
	public function addError($messageNR){
	switch ($messageNR) {
		case 1:
			$message = "Fel mail eller lösenord!";
			break;
		case 2:
			$message = "Fyll i mail och lösenord!";
			break;
		case 3:
			$message = "Otillåtna Tecken!";
			break;
		default:
			$message = "oidentifierat Fel!";
			break;
	}
		$this->errorList .= "<li>".$message."</li>";
	}
}
