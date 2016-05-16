<?php
require_once "userPage/view/loginView.php";
require_once "userPage/model/loginModel.php";
require_once "userPage/view/mainView.php";
require_once "userPageController.php";

Class MainController {
	private $loginView;
	private $mainView;
	private $commonLoginModel;
	private $loginModel;
	private $userPageController;

	public function __construct(){
		$this->loginModel = new LoginModel();
		$this->loginView = new LoginView($this->loginModel);		
		$this->mainView = new MainView();
		$this->userPageController = new UserPageController();
	}
	
	//returns string HTML
	public function startController(){
		$HTML = $this->mainView->getFirstHTML();
		$HTML .= $this->getHTML();
		$HTML .= $this->mainView->getLastHTML();
		return $HTML;
	}
	
	//returns loginpage or loggedInPage
	private function getHTML(){
		if($this->loginModel->checkIfLoggedIn()){
			return $this->whenLoggedIn();
		}else{ 
			return $this->logInFunction();
		}
	}
	//if logged in
	private function whenLoggedIn(){
		if($this->mainView->checkLogOutButton()){
			$this->loginModel->logOut();
		}
		$HTML = $this->userPageController->getHTML($this->loginModel->userObject);
		return $HTML;
	}
	//if not logged in
	private function logInFunction(){
		if($this->loginView->checkLoginButton()){ //if trying to login
			if($this->tryLogin()){
				return $this->whenLoggedIn();
			}
		}
		return $this->loginView->getLoginHTML(); //output login page
		
	}
	
	private function tryLogin(){
		if($this->loginView->viewCheck()){
			$mail = $this->loginView->getMail();
			$password = $this->loginView->getPassword();
			if($this->loginModel->tryLogin($mail, $password)){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
}


































