<?php
require_once "userPage/model/uploadPic.php";
require_once "DAL.php";

Class ArticleModel{
	private $validInput;
	private $uploadPic;
	private $DAL;
	private $userObject;
	public $typeId;
	public $messageNR = array();
	const typeIdYoutube = 2;
	const typeIdImage = 1;
	const typeIdNone = 3;
	const maxTitleChars = 500;
	const maxTextChars = 10000;
	
	public function __construct(){
		$this->uploadPic = new UploadPic();
		$this->DAL = new DAL();
	}
	//if trying to send in article
	public function postArticle($title, $text, $pic, $youtubeLink, $link, $linkShortName, $anonymous, $userObject){
		$this->validInput = TRUE;
		$this->userObject = $userObject;
		$this->titleValidation($title);
		if($this->DAL->checkIfTitleExist($title)){
			$this->validInput = FALSE;
			$this->addMessageNR(3);
		}
		$this->textValidation($text);
		$this->fileValidation($pic, $youtubeLink);
		$anonymous = $this->convertBoolToInt($anonymous);
		$status = $this->setArticleStatus($userObject->isAdmin);
		if($this->validInput == TRUE){
			$this->addMessageNR(1);
			$this->saveArticle($title, $text, $pic, $youtubeLink, $link, $linkShortName, $anonymous, $status, $userObject->id);	
		}
	}
	//if trying to edit article
	public function checkForEditArticle($articleTitle, $articlePic, $articleYoutubeLink, 
								$articleText, $articleAnynomous, $articleLink,
								$articleShortLink, $articleStatus){
		$this->validInput = TRUE;
		$this->titleValidation($articleTitle);
		$this->fileValidation($articlePic, $articleYoutubeLink);
		$this->textValidation($articleText);
		return $this->validInput;
		
	}

	private function saveArticle($title, $text, $pic, $youtubeLink, $link, $linkShortName, $anonymous, $status, $userId){
		$fileName = $this->uploadFile($pic, $youtubeLink, $title);
		$fileId = $this->DAL->addFile2($fileName,$this->typeId);
		
		$this->DAL->addArticle($fileId, $title, $text, $link, $linkShortName, $anonymous, $status, $userId);
	}
	
	public function uploadFile($pic, $youtubeLink, $title){
		if($this->uploadPic->uploadImage($pic, $title)){
			$fileName = $this->uploadPic->fileName;
			$this->typeId = self::typeIdImage;
		}else if(!empty($youtubeLink)){									
			$fileName = $youtubeLink;
			$this->typeId = self::typeIdYoutube;
		}else{
			$fileName = "none";
			$this->typeId = self::typeIdNone;
		}
		return $fileName;
	}
	
	private function titleValidation($title){
		if(strlen($title) > self::maxTitleChars){
			$this->validInput = FALSE;
			$this->addMessageNR(2);
		}
		if(empty($title)){
			$this->validInput = FALSE;
			$this->addMessageNR(4);
		}
		if($this->stripFunction($title)){
			$this->validInput = FALSE;
			$this->addMessageNR(5);
		}
	}
	private function textValidation($text){
		if(strlen($text) > self::maxTextChars){
			$this->validInput = FALSE;
			$this->addMessageNR(6);
		}
		if(empty($text)){
			$this->validInput = FALSE;
			$this->addMessageNR(7);
		}
		if($this->stripFunction($text)){
			$this->validInput = FALSE;
			$this->addMessageNR(8);
		}
	}
	private function setArticleStatus($isAdmin){
		if($isAdmin == TRUE){
			return 2; //status published
		}
		return 1; //status pending
	}
	private function fileValidation($pic, $youtubeLink){
		if(!empty($pic["string"]) && !empty($youtubeLink)){
			$this->validInput = FALSE;
			$this->addMessageNR(9);
		}else if(!empty($pic["string"])){
			if($this->uploadPic->checkFileType($pic)){
				$this->validInput = FALSE;
				$this->addMessageNR(10);
			}
			if($pic['error']){
				$this->validInput = FALSE;
				$this->addMessageNR(11);
			}else if($this->uploadPic->checkFileSize($pic)){
				$this->validInput = FALSE;
				$this->addMessageNR(13);
			}
		}else if(!empty($youtubeLink)){
			$link = parse_url($youtubeLink);
			if(!isset($link['host']) || $link['host'] != 'www.youtube.com'){
				$this->validInput = FALSE;
				$this->addMessageNR(12);
			}
		}
	}
	private function stripFunction($string){
		$strippedString = strip_tags($string);
		if($string === $strippedString){
			return FALSE;
		}
		return TRUE;
	}
	public function convertBoolToInt($anonymous){
		if($anonymous == "true"){
			$anonymous = 1; //true
		}else{
			$anonymous = 0; //false
		}
		return $anonymous;
	}
	private function addMessageNR($nr){
		$this->messageNR[] = $nr;
	}
}
