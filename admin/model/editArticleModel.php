<?php
require_once 'userPage/model/articleModel.php';
require_once 'adminDAL.php';

Class EditArticleModel{
	private $articleModel;
	private $adminDAL;
	public function __construct(){
		$this->articleModel = new articleModel();
		$this->adminDAL = new AdminDAL();
	}
	
	public function editArticle($articleId, $articleTitle, $articlePic, $articleYoutubeLink, 
								$articleText, $articleAnynomous, $articleLink,
								$articleShortLink, $articleStatus,$deleteFile){
		
		$validateInput = $this->articleModel->checkForEditArticle($articleTitle, $articlePic, $articleYoutubeLink, 
								$articleText, $articleAnynomous, $articleLink,
								$articleShortLink, $articleStatus);
		$articleAnynomous = $this->articleModel->convertBoolToInt($articleAnynomous);

		if($validateInput){
			$this->editFile($articlePic, $articleYoutubeLink, $articleTitle, $deleteFile, $articleId);
			
			$this->adminDAL->editArticle($articleId, $articleTitle, $articleText, $articleAnynomous, $articleLink, $articleShortLink, $articleStatus);
		}
	}
	private function editFile($pic, $youtubeLink, $title, $deleteFile, $articleId){
		$fileName = $this->articleModel->uploadFile($pic, $youtubeLink, $title);
		if($this->articleModel->typeId != 3 || $deleteFile == TRUE){
			$this->adminDAL->editFile($fileName, $articleId, $this->articleModel->typeId);
		}
	}
		
	public function deleteArticle($id){
		$this->adminDAL->deleteArticle($id);
	}
	
	public function getMessageNr(){
		return $this->articleModel->messageNR;
	}
}
