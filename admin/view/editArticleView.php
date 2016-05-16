<?php
require_once 'common/commonView.php';

Class EditArticleView{
	private static $newArticlePic = 'newArticlePic';
	private static $newArticleYoutubeLink = 'newArticleYoutubeLink';
	private static $newArticleTitle = 'newArticleTitle';
	private static $newArticleText = 'newArticleText';
	private static $newRadioAnonymous ='newRadioAnonymous';
	private static $newArticleLink = 'newArticleLink';
	private static $newArticleLinkShortName = 'newArticleLinkShortName';
	private static $newArticleStatus = 'newArticleStatus';
	private $commonView;
	private static $editArticleBtn = 'editArticleBtn';
	private static $deleteArticleBtn = 'deleteArticleBtn';
	private static $editArticleId = 'editTheArticleId';
	private static $checkDeleteFile = 'checkDeleteFile';
	private $errorList = '';
	
	public function __construct(){
		$this->commonView = new CommonView();
	}
	
	public function checkEditArticleBtn(){
		if(isset($_POST[self::$editArticleBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getArticleId(){
		return $_POST[self::$editArticleId];
	}
	public function checkDeleteArticleBtn(){
		if(isset($_POST[self::$deleteArticleBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNewArticlePic(){
		if(isset($_FILES[self::$newArticlePic])){
			return $_FILES[self::$newArticlePic];	
		}
	}
	public function getNewArticleYoutubeLink(){
		return $_POST[self::$newArticleYoutubeLink];
	}
	public function getNewArticleTitle(){
		return $_POST[self::$newArticleTitle];
	}
	public function getNewArticleText(){
		return $_POST[self::$newArticleText];
	}
	public function getNewRadioAnonymous(){
		return $_POST[self::$newRadioAnonymous];
	}
	public function getNewArticleLink(){
		return $_POST[self::$newArticleLink];
	}
	public function getNewArticleLinkShortName(){
		return $_POST[self::$newArticleLinkShortName];
	}
	public function getNewArticleStatus(){
		return $_POST[self::$newArticleStatus];
	}
	public function getCheckDeleteFile(){
		if(isset($_POST[self::$checkDeleteFile])){
			return TRUE;
		}
		return FALSE;
	}
	
	public function getTheArticleToEdit($articleObject, $articleId, $messageNr){
		$HTML = "";
		foreach ($messageNr as $i) {
			$this->addError($i);
		}
		foreach ($articleObject as $article) {
			if($article->articleId == $articleId){
				$HTML .= $this->getEditArticleHTML($article);	
			}	
		}
		return $HTML;
	}
	private function getEditArticleHTML($article){
		$HTML = "<div class='article'>
					<ul>$this->errorList</ul>
					<form method='post' role='form' name='editArticleBtn' enctype='multipart/form-data' accept-charset='UTF-8'>	
					<input type='submit' name='".self::$deleteArticleBtn."' id='deleteArticleBtn' value='Radera'>
						<div class='articleTitle'>
							<h3><input type='text' name='".self::$newArticleTitle."' value='$article->title' style = 'width:100%'></h3>
						</div>
						<div class='form-group'>
	    					<label for='".self::$newArticlePic."'>Ny Bild: </label>
							<input type='file' name='".self::$newArticlePic."' id='newArticlePic' >
							Eller Ny Youtubelänk! <input type='text' class='form-control' name='".self::$newArticleYoutubeLink."' id='articleYoutubeLink'>
						</div>
						
							<label for='".self::$checkDeleteFile."'>Ta bort bild/youtube-video</label>
							<input type='checkbox' name='".self::$checkDeleteFile."' class='checkDeleteFile' value='true' />
						
						<div class='articleFile'>"
							. $this->getFileHTML($article->fileType, $article->fileName) . //gets Image, Youtube or none HTML
						"</div>
						<div class='articleText'>
							<textarea class='form-control'  name='".self::$newArticleText."' id='newArticleText' rows='10' cols='30'>".$article->text."</textarea>
							<div class='articleLink'>
								<a href='$article->link' target='_blank'>$article->shortLink</a>
							</div>
						</div>
						Ny Länk: <input type='text' class='form-control' value='$article->link' name='".self::$newArticleLink."' id='articleLink'>
					 Ny Förkottat länknamn: <input type='text' class='form-control' value='$article->shortLink' name='".self::$newArticleLinkShortName."' id='articleLinkShortName'>
					  ".$this->getArticleStatusDropDown($article->statusId)."
						<p class='articleFooter'> Skriven av: $article->name $article->date </p>
						 Anonym?
						<div class='checkbox'>
						".$this->getRadioAnonymous($article->anonymous)."
						<input type='hidden' value='".$article->articleId."' name='".self::$editArticleId."'>
						<input type='submit' class='btn btn-primary btn-lg' name='".self::$editArticleBtn."' value='Redigera' id='editArticleBtn' >
					</form>
				</div>";
			return $HTML;
	}
	private function getArticleStatusDropDown($statusId){
		switch ($statusId) {
			case 1:
				$HTML = '<select name="'.self::$newArticleStatus.'">
						    <option value="1" selected="selected">Pending</option>
						    <option value="2">Published</option>
						    <option value="3">Denied</option>
						</select>';
				break;
			case 2:
				$HTML = '<select name="'.self::$newArticleStatus.'">
						    <option value="1" >Pending</option>
						    <option value="2" selected="selected">Published</option>
						    <option value="3">Denied</option>
						</select>';
				break;
			case 3:
				$HTML = '<select name="'.self::$newArticleStatus.'">
						    <option value="1" >Pending</option>
						    <option value="2" >Published</option>
						    <option value="3" selected="selected">Denied</option>
						</select>';
				break;
			default:
				$HTML = '';
				break;
		}	
		return $HTML;
	}
	private function getRadioAnonymous($anonymous){
		switch ($anonymous) {
			case 1:
					$HTML = "<input type='radio' name='".self::$newRadioAnonymous."' class='radioAnonymous' value='true' checked /> Ja 
		    			<input type='radio' name='".self::$newRadioAnonymous."' class='radioAnonymous' value='false'  /> Nej";
				break;
			
			default:
				$HTML = "<input type='radio' name='".self::$newRadioAnonymous."' class='radioAnonymous' value='true' /> Ja 
		    			<input type='radio' name='".self::$newRadioAnonymous."' class='radioAnonymous' value='false' checked /> Nej";
				break;
		}
		return $HTML;
	}
	
	private function getFileHTML($fileType, $fileName){
		return $this->commonView->getFileHTML($fileType, $fileName);
	}
	
	private function addError($messageNR){
		switch ($messageNR) {
			case 1:
				$message = "Artikel väntas nu på att godkännas!!";
				break;
			case 2:
				$message = "Titeln är för lång!";
				break;
			case 3:
				$message = "Det existerar redan en artikel med samma titel!";
				break;
			case 4:
				$message = "Titeln får inte vara tom!";
				break;
			case 5:
				$message = "Titel innehåller otillåtna tecken!";
				break;
			case 6:
				$message = "seriöst? ska du publicera en en bok eller?";
				break;
			case 7:
				$message = "Text får inte vara tom";
				break;
			case 8:
				$message = "text inehåller otillåtna tecken!";
				break;
			case 9:
				$message = "Du får endast ha en bild eller en youtubelänk";
				break;
			case 10:
				$message = "Otillåtet bildformat! (måste vara jpeg,jpg,png)";
				break;
			case 11:
				$message = "Något fel med bildfilen";
				break;
			case 12:
				$message = "Ogiltlig youtubelänk";
				break;
			case 13:
				$message = "Bildstorlek är för stor";
				break;
			default:
				$message = "oidentifierat Fel!";
				break;
		}
		$this->errorList .= "<li>".$message."</li>";
	}
}
