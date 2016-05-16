<?php

Class RegisterView{
	private $errorList = '';
	private static $regMail = 'regMail';
	private static $regPassword = 'regPassword';
	private static $regPassword2 = 'regPassword2';
	private static $firstname = 'firstname';
	private static $lastname = 'lastname';
	private static $regButton = 'regButton';
	
	public function checkregButton(){
		if(isset($_POST[self::$regButton])){
			if($this->viewCheckRegForm()){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	public function getregMail(){
		return $_POST[self::$regMail];
	}
	public function getRegPassword(){
		return $_POST[self::$regPassword];             //TODO else throw exception
	}
	public function getRegPassword2(){
		return $_POST[self::$regPassword2];
	}
	public function getFirstname(){
		return $_POST[self::$firstname];
	}
	public function getLastname(){
		return $_POST[self::$lastname];
	}
	
	public function getRegForm(){
		$mail = "";
		$firstname = "";
		$lastname = "";
		if(isset($_POST[self::$regMail])){
			$mail = $_POST[self::$regMail];
		}
		if(isset($_POST[self::$firstname])){
			$firstname = $_POST[self::$firstname];
		}
		if(isset($_POST[self::$lastname])){
			$lastname = $_POST[self::$lastname];
		}
		$regFormHTML = "
			<div id='registerDiv'>
				<h3>Registrera användare</h3>
				<ul>$this->errorList</ul>
				<form id='registerForm' method='post' role='form'>
					<div class='form-group'>
						Mail: <input type='text' class='form-control' value='$mail' name='".self::$regMail."' id='regMail'>
					</div>
					<div class='form-group'>
						Lösernord: <input type='password' class='form-control' name='".self::$regPassword."' id='regPassword'>
					</div>
					<div class='form-group'>
						Lösenord: <input type='password' class='form-control' name='".self::$regPassword2."' id='regPassword2'>
					</div>
					<div class='form-group'>
						Förnamn: <input type='text' class='form-control' value='$firstname' name='".self::$firstname."' id='firstname'>
					</div>
					<div class='form-group'>
						Efternamen: <input type='text' class='form-control' value='$lastname' name='".self::$lastname."' id='lastname'>
					</div>
					<input type='submit' class='btn btn-primary btn-lg' name='".self::$regButton."' id='regButton'> 
				</form>
			</div>
		";
		return $regFormHTML;
	}
	private function viewCheckRegForm(){
		$check = TRUE;
		//TODO Mail check, pw check etcetc
		if(empty($_POST[self::$regMail]) || empty($_POST[self::$regPassword]) || empty($_POST[self::$regPassword2]) 
			|| empty($_POST[self::$firstname]) || empty($_POST[self::$lastname])){
			$check = FALSE;
			$this->addError(1);
		}
		if($_POST[self::$regPassword] != $_POST[self::$regPassword2] ){
			$check = FALSE;
			$this->addError(2);
		}

		return $check;
	}
	public function addError($messageNR){
		switch ($messageNR) {
			case 1:
				$message = "Fyll i alla fält!";
				break;
			case 2:
				$message = "Lösenorden matchar inte varandra";
				break;
			case 3:
				$message = "Lösenordet måste vara minst 5tecken långt!";
				break;
			case 4:
				$message = "Ogiltilig mail!";
				break;
			case 5:
				$message = "Inget får vara mer än 50 tecken långt!";
				break;
			case 6:
				$message = "Mailadressen finns redan registrerad!";
				break;
			case 7:
				$message = "Ogiltiga tecken!";
				break;
			case 8:
				$message = "Registrering misslyckades!";
				break;
			case 9:
				$message = "Registrering lyckades!!";
				break;
			default:
				$message = "oidentifierat Fel!";
				break;
		}
		$this->errorList .= "<li>".$message."</li>";
	}
}














