<?php
require_once 'view/mainPageView.php';
require_once 'model/mainPageModel.php';


Class MainPageController{
	private $mainPageModel;
	private $mainPageView;
	
	public function __construct(){
		$this->mainPageModel = new MainPageModel();
		$this->mainPageView = new MainPageView();
	}
	
	//return string HTML
	public function getHTML(){
		$this->mainPageModel->getArticles();
		$HTML = $this->mainPageView->getFirstHTML();
		if($this->mainPageView->checkGetArticle()){
			$HTML .= $this->mainPageView->getTheArticle($this->mainPageModel->articleObject);
		}else if($this->mainPageView->checkAboutBtn()){
			$HTML .= $this->mainPageView->getAboutHTML();
		}else{
			$pageNr = $this->mainPageView->getPageNr();
			$HTML .= $this->mainPageView->getArticles($this->mainPageModel->articleObject, $pageNr);
			$HTML .= $this->mainPageView->getNavHTML($pageNr);
		}
		$HTML .= $this->mainPageView->getLastHTML();
		return $HTML;
	}
}
