<?php

Class AllUsersView{
	private static $editUser = 'editUser';
	private static $editFirstname = 'editFirstname';
	private static $editLastname = 'editLastname';
	private static $editMail = 'editMail';
	private static $editRole = 'editRole';
	private static $editPassword = 'editPassword';
	private static $editPassword2 = 'editPassword2';
	private static $editUserBtn = 'editUserBtn';
	private static $editUserPasswordBtn = 'editUserPasswordBtn';
	private $errorList = '';
	
	
	public function checkEditUserBtn(){
		if(isset($_POST[self::$editUserBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function checkEditUserPasswordBtn(){
		if(isset($_POST[self::$editUserPasswordBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getEditFirstname(){
		if(isset($_POST[self::$editFirstname])){
			return $_POST[self::$editFirstname];	
		}
	}
	public function getEditLastname(){
		if(isset($_POST[self::$editLastname])){
			return $_POST[self::$editLastname];	
		}
	}
	public function getEditMail(){
		if(isset($_POST[self::$editMail])){
			return $_POST[self::$editMail];	
		}
	}
	public function getEditRole(){
		if(isset($_POST[self::$editRole])){
			return $_POST[self::$editRole];	
		}
	}

	public function getNewPassword1(){
		return $_POST[self::$editPassword];
	}
	public function getNewPassword2(){
		return $_POST[self::$editPassword2];
	}
	public function checkEditUser(){
		if(isset($_GET[self::$editUser])){
			return TRUE;
		}
		return FALSE;
	}
	public function getEditUserId(){
		return $_GET[self::$editUser];
	}
	public function getAllUsersHTML($allUsersObject){
		$HTML = "<div id='userList'>
					<ul>
						<h4>Lista på användare</h4>";
		foreach ($allUsersObject as $object) {
			$HTML .= $this->getUserHTML($object);
		}
		$HTML .= "</ul>
				</div";
		return $HTML;
	}
	public function getTheEditUserHTML($allUsersObject, $messageNR){
		$userId = $this->getEditUserId();
		$HTML = "<h4>Redigera Användare!</h4>";
		foreach ($allUsersObject as $object) {
			if($object->userId == $userId){
				$HTML .= $this->getTheUserHTML($object,$messageNR);
			}
		}
		return $HTML;
	}
	private function getUserHTML($object)
	{
		$HTML = "<li>
					$object->firstname $object->lastname
					<a class='editUser' href='userpage.php?".self::$editUser."=$object->userId'>Redigera</a>
					<ul>
						<li>Mail: $object->mail</li>
						<li>Roll: $object->role</li>
						<li>Registrerings Datum: $object->regDate</li>
					</ul>
				</li>";
		return $HTML;
	}
	private function getTheUserHTML($object, $messageNR){
		foreach ($messageNR as $i) {
			$this->addError($i);
		}
		$HTML = "<form id='editUserForm' method='post' role='form'>
		<ul>$this->errorList</ul>
					<div class='form-group'>
						<label for='".self::$editFirstname."'>Förnamn</label>
						<input type='text' class='form-control' value='$object->firstname' name='".self::$editFirstname."' id='editFirstname'>
						<label for='".self::$editLastname."'>Efternamn</label>
						<input type='text' class='form-control' value='$object->lastname' name='".self::$editLastname."' id='editLastname'>
						<label for='".self::$editMail."'>Mail</label>
						<input type='text' class='form-control' value='$object->mail' name='".self::$editMail."' id='editMail'>
						<label for='".self::$editRole."'>Ändra Roll</label>
						".$this->getRolesDropDown($object->role)."
						<input type='submit' name='".self::$editUserBtn."' class='btn btn-primary btn-lg' value='Redigera' id='editUserBtn'>
					</div>
				</form>
				
				<form id='editUserFormPassword' method='post' role='form'>
					<h4>Ändra lösenord</h4>
					<div class='form-group'>
						<label for='".self::$editPassword."'>Nytt Lösenord</label>
						<input type='password' class='form-control' name='".self::$editPassword."' id='editPassword'>
						<label for='".self::$editPassword2."'>Repetera Lösenord</label>
						<input type='password' class='form-control' name='".self::$editPassword2."' id='editPassword2'>
					</div>
					<input type='submit' name='".self::$editUserPasswordBtn."' class='btn btn-primary btn-lg' value='Redigera' id='editUserPasswordBtn'>
				</form>";
		return $HTML;
	}

	private function getRolesDropDown($role){
		switch ($role) {
			case 'Admin':
				$HTML = '<select name="'.self::$editRole.'">
						    <option value="1" selected="selected">Admin</option>
						    <option value="2">Journalist</option>
						    <option value="3">Frozen</option>
						</select>';
				break;
			case 'Journalist':
				$HTML = '<select name="'.self::$editRole.'">
						    <option value="1" >Admin</option>
						    <option value="2" selected="selected">Journalist</option>
						    <option value="3">Frozen</option>
						</select>';
				break;
			case 'Frozen':
				$HTML = '<select name="'.self::$editRole.'">
						    <option value="1" >Admin</option>
						    <option value="2" >Journalist</option>
						    <option value="3" selected="selected">Frozen</option>
						</select>';
				break;
			default:
				$HTML = '<select name="'.self::$editRole.'">
						    <option value="1" >Admin</option>
						    <option value="2" >Journalist</option>
						    <option value="3" >Frozen</option>
						</select>';
				break;
		}	
		return $HTML;
	}

	private function addError($messageNR){
		switch ($messageNR) {
			case 1:
				$message = "Du missade fylla i ett fält!";
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
































