<?php
require_once"view/registerView.php";
require_once"model/registerModel.php";
require_once"view/pendingArticleView.php";
require_once"model/adminArticleModel.php";
require_once"view/adminMainView.php";
require_once"view/adminAllArticlesView.php";
require_once 'view/editArticleView.php';
require_once 'model/editArticleModel.php';
require_once 'view/allUsersView.php';
require_once 'model/allUsersModel.php';

Class AdminController{
	private $registerView;
	private $registerModel;
	private $pendingArticleView;
	private $adminArticleModel;
	private $adminMainView;
	private $adminAllArticles;
	private $editArticleView;
	private $editArticleModel;
	private $allUsersView;
	private $allUsersModel;
	
	public function __construct(){
		$this->registerView = new RegisterView();		
		$this->registerModel = new RegisterModel();
		$this->pendingArticleView = new PendingArticleView();
		$this->adminArticleModel = new AdminArticleModel();
		$this->adminMainView = new AdminMainView();
		$this->adminAllArticlesView = new AdminAllArticlesView();
		$this->editArticleView = new EditArticleView();
		$this->editArticleModel = new EditArticleModel();
		$this->allUsersView = new AllUsersView();
		$this->allUsersModel = new AllUsersModel();
	}
	public function getAdminHTML(){
		$HTML = "";
		$HTML .= $this->getAdminNav();
		if($this->adminMainView->getNavRegister()){
			$HTML .= $this->getRegForm();	
		}else if($this->adminMainView->getNavAllArticles()){
			$HTML .= $this->getAllArticles();
		}else if($this->adminAllArticlesView->checkIfEditArticle()){
			$HTML .=$this->editArticle();
		}else if($this->adminMainView->getNavUsers()){
			$HTML .= $this->getAllUsers();
		}else if($this->allUsersView->checkEditUser()){
			$HTML .= $this->editUser();
		}
		else{
			$HTML .= $this->getPendingArticles();	
		}
		return $HTML;
	}
	public function getAdminNav(){
		return $this->adminMainView->getAdminNavHTML();
	}
	public function checkIfAdminPostArticle(){
		if($this->adminMainView->getNavPostArticles()){
			return TRUE;
		}
		return FALSE;
	}
	
	//form for registering new user
	private function getRegForm(){
		if($this->registerView->checkregButton()){
			$mail = $this->registerView->getregMail();
			$password = $this->registerView->getRegPassword();
			$password2 = $this->registerView->getRegPassword2();
			$firstname = $this->registerView->getFirstname();
			$lastname = $this->registerView->getLastname();
			$this->registerModel->register($mail, $password, $password2, $firstname, $lastname);
		}
		$this->errorHandler();
		return $this->registerView->getRegForm();
	}
	private function getAllArticles(){
		$this->adminArticleModel->setAdminArticleObject();
		if($this->adminAllArticlesView->checkIfEditArticle()){
			$HTML = $this->editArticle();
		}else{
			$HTML = $this->adminAllArticlesView->getAllArticlesHTML($this->adminArticleModel->adminArticleObject);	
		}
		
		return $HTML;
	}
	private function editArticle(){
		if($this->editArticleView->checkEditArticleBtn()){
			$this->editTheArticle();
		}else if($this->editArticleView->checkDeleteArticleBtn()){
			$this->deleteTheArticle();
		}
		$this->adminArticleModel->setAdminArticleObject();
		$editArticleId = $this->adminAllArticlesView->getEditArticleId();
		$messageNr = $this->editArticleModel->getMessageNr();
		$HTML = $this->editArticleView->getTheArticleToEdit($this->adminArticleModel->adminArticleObject, $editArticleId, $messageNr);
		return $HTML;
	}
	private function editTheArticle(){
			$articleId = $this->editArticleView->getArticleId();
			$articleTitle = $this->editArticleView->getNewArticleTitle();
			$articlePic = $this->editArticleView->getNewArticlePic();
			$articleYoutubeLink = $this->editArticleView->getNewArticleYoutubeLink();
			$articleText = $this->editArticleView->getNewArticleText();
			$articleAnynomous = $this->editArticleView->getNewRadioAnonymous();
			$articleLink = $this->editArticleView->getNewArticleLink();
			$articleShortLink = $this->editArticleView->getNewArticleLinkShortName();
			$articleStatus = $this->editArticleView->getNewArticleStatus();
			$deleteFile = $this->editArticleView->getCheckDeleteFile();;
			$this->editArticleModel->editArticle($articleId, $articleTitle, $articlePic, $articleYoutubeLink, 
													$articleText, $articleAnynomous, $articleLink,
													$articleShortLink, $articleStatus,$deleteFile);
	}
	private function deleteTheArticle(){
			$articleId = $this->editArticleView->getArticleId();
			$this->editArticleModel->deleteArticle($articleId);
	}
	private function getPendingArticles(){
		if($this->pendingArticleView->getAcceptPendingBtn()){
			$articleId = $this->pendingArticleView->getPendingArticleId();
			$this->adminArticleModel->acceptArticle($articleId);
		}else if($this->pendingArticleView->getDeniedPendingBtn()){
			$articleId = $this->pendingArticleView->getPendingArticleId();
			$this->adminArticleModel->denyArticle($articleId);
		}
		$this->adminArticleModel->setAdminArticleObject();
		$HTML = $this->pendingArticleView->getPendingArticlesHTML($this->adminArticleModel->adminArticleObject);
		return $HTML;
	}
	private function getAllUsers(){
		$allUsersObject = $this->allUsersModel->getAllUsers();
		$HTML = $this->allUsersView->getAllUsersHTML($allUsersObject);
		return $HTML;
	}
	private function editUser(){
		if($this->allUsersView->checkEditUserPasswordBtn()){
			$password = $this->allUsersView->getNewPassword1();
			$password2 = $this->allUsersView->getNewPassword2();
			$userId = $this->allUsersView->getEditUserId();
			$this->allUsersModel->changeNewPassword($password, $password2, $userId);
		}else if($this->allUsersView->checkEditUserBtn()){
			$firstname = $this->allUsersView->getEditFirstname();
			$lastname = $this->allUsersView->getEditLastname();
			$mail = $this->allUsersView->getEditMail();
			$role = $this->allUsersView->getEditRole();
			$userId = $this->allUsersView->getEditUserId();
			$this->allUsersModel->editUser($firstname,$lastname,$mail, $role,$userId);
		}
		$messageNr = $this->allUsersModel->getMessageNr();
		$allUsersObject = $this->allUsersModel->getAllUsers();
		$HTML = $this->allUsersView->getTheEditUserHTML($allUsersObject, $messageNr);
		return $HTML;
	}
	private function errorHandler(){
		$messageArray = $this->registerModel->messageNR;
		foreach ($messageArray as $i) {
			$this->registerView->addError($i);
		}
	}
}
