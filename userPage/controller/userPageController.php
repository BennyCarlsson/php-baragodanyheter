<?php
require_once "userPage/view/postArticleView.php";
require_once "admin/adminController.php";
require_once "userPage/model/articleModel.php";
require_once "userPage/view/mainView.php";


Class UserPageController{
	private $userObject;
	private $articleModel;
	private $postArticleView;
	private $adminController;
	private $mainView;
	
	public function __construct(){
		$this->mainView = new MainView();
		$this->articleModel = new articleModel();
		$this->postArticleView = new PostArticleView();	
		$this->adminController = new AdminController($this->mainView);
		
	}
	//returns logged in userpage
	public function getHTML($userObject){
		$this->userObject = $userObject;
		$HTML = "";
		$HTML .= $this->mainView->getLogoutHTML();
		
		if($this->userObject->userRole == 3){ //if is frozen
			$HTML .= $this->mainView->getFrozenHTML();
		}else if($this->userObject->isAdmin){ //if admin
			$HTML .= $this->adminUser();
		}else{
			$HTML .= $this->articleFunction();
		}
		return $HTML;
	}
	
	//if admin is logged in
	//return string admin logged in HTML
	private function adminUser(){
		$HTML = "";
		if($this->adminController->checkIfAdminPostArticle()){
			$HTML .= $this->adminController->getAdminNav();
			$HTML .= $this->articleFunction();
		}else{
			$HTML .= $this->adminController->getAdminHTML();
		}
		return $HTML;
	}
	//returns string HTML send in article form
	private function articleFunction(){
		if($this->postArticleView->checkArticleButton()){
			$this->articlePost();
		}
		$messageNr = $this->articleModel->messageNR;
		$this->postArticleView->addErrorList($messageNr);
		$HTML = $this->postArticleView->getArticleFormHTML();
		return $HTML;
	}
	
	//if sending in article
	private function articlePost(){
		$title = $this->postArticleView->getArticleTitle();
		$text = $this->postArticleView->getArticleText();
		$pic = $this->postArticleView->getArticlePic();
		$youtubeLink = $this->postArticleView->getYoutubeLink();
		$link = $this->postArticleView->getArticleLink();
		$linkShortName = $this->postArticleView->getArticleLinkShortName();
		$anonymous = $this->postArticleView->getRadioAnonymous();
		$this->articleModel->postArticle($title, $text, $pic, $youtubeLink, $link, $linkShortName, $anonymous,$this->userObject);
	}
}














