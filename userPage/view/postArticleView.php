<?php

Class PostArticleView{
	private $errorList = '';
	private static $articlePic = 'articlePic';
	private static $articleYoutubeLink = 'articleYoutubeLink';
	private static $articleTitle = 'articleTitle';
	private static $articleText = 'articleText';
	private static $radioAnonymous ='radioAnonymous';
	private static $articleButton = 'articleButton';
	private static $articleLink = 'articleLink';
	private static $articleLinkShortName = 'articleLinkShortName';
	
	public function checkArticleButton(){
		if(isset($_POST[self::$articleButton])){
			return TRUE;
		}
		return FALSE;
	}
	
	public function getArticlePic(){
		if(isset($_FILES[self::$articlePic])){
			return $_FILES[self::$articlePic];
		}
	}
	public function getYoutubeLink(){
		if(isset($_POST[self::$articleYoutubeLink])){
			return  $_POST[self::$articleYoutubeLink];
		}
	}
	public function getArticleTitle(){
		if(isset($_POST[self::$articleTitle])){
			return $_POST[self::$articleTitle];	
		}
		
	}
	public function getArticleText(){
		if(isset($_POST[self::$articleText])){
			return $_POST[self::$articleText];
		}
	}
	public function getArticleLink(){
		if(isset($_POST[self::$articleLink])){
			return $_POST[self::$articleLink];
		}
	}
	public function getArticleLinkShortName(){
		if(isset($_POST[self::$articleLinkShortName])){
			return $_POST[self::$articleLinkShortName];
		}
	}
	public function getRadioAnonymous(){
		if(isset($_POST[self::$radioAnonymous])){
			return $_POST[self::$radioAnonymous];
		}
	}
	public function getArticleFormHTML(){
		$youtubelink = $this->getPostYoutubeLink();
		$title = $this->getPostTitle();
		$text = $this->getPostText();
		$link = $this->getPostLink();
		$shortLink = $this->getPostShortLink();
		$HTML = "
			<div id='articleForm'>
			<ul>$this->errorList</ul>
				<form method='post' role='form' name='articleForm' id='articleForm' enctype='multipart/form-data' accept-charset='UTF-8' >
					<h3>Skicka in artikel!</h3>
					<div class='form-group'>
    					<label for='".self::$articlePic."'>Bild: </label>
						<input type='file' name='".self::$articlePic."' id='articlePic' >
						Eller Youtubelänk! <input type='text' value='$youtubelink' placeholder='www.youtube.com/watch?v=loremipsum' class='form-control' name='".self::$articleYoutubeLink."' id='articleYoutubeLink'>
					</div>
					<br/>
					Titel*: <input type='text' placeholder='Titel!' value='$title' class='form-control' name='".self::$articleTitle."' id='articleTitle'>
					<br/>
					Text*: <textarea class='form-control' placeholder='Lorem ipsum...' name='".self::$articleText."' id='articleText' rows='10' cols='30'>$text</textarea>
					<br/>
					Länk: <input type='text' class='form-control' value='$link' name='".self::$articleLink."' id='articleLink'> <p class='help-block'>Exempel: https://www.facebook.com/benny.k.carlsson</p>
					Förkottat länknamn: <input type='text' class='form-control' value='$shortLink' name='".self::$articleLinkShortName."' id='articleLinkShortName'> <p class='help-block'>Exempel: Facebook</p>
					<br />
					Anonym?
					<div class='checkbox'>
					<input type='radio' name='".self::$radioAnonymous."' class='radioAnonymous' value='true' /> Ja 
	    			<input type='radio' name='".self::$radioAnonymous."' class='radioAnonymous' value='false' checked /> Nej
	    			<p class='help-block'>Väljer du att vara anonym kommer ditt namn inte synas på hemsidan men sparas fortfarande i databasen</p>
	    			</div>
	    			<input type='submit' class='btn btn-primary btn-lg' name='".self::$articleButton."' id='articleButton'>
				</form>
			</div>
		";
		return $HTML;
	}
	private function getPostYoutubeLink(){
		if(isset($_POST[self::$articleYoutubeLink])){
			return $_POST[self::$articleYoutubeLink];
		}
		return "";
	}
	private function getPostTitle(){
		if(isset($_POST[self::$articleTitle])){
			return $_POST[self::$articleTitle];
		}
		return "";
	}
	private function getPostText(){
		if(isset($_POST[self::$articleText])){
			return $_POST[self::$articleText];
		}
		return "";
	}
	private function getPostLink(){
		if(isset($_POST[self::$articleLink])){
			return $_POST[self::$articleLink];
		}
		return "";
	}
	private function getPostShortLink(){
		if(isset($_POST[self::$articleLinkShortName])){
			return $_POST[self::$articleLinkShortName];
		}
		return "";
	}
	public function addErrorList($messageNR){
		foreach ($messageNR as $nr) {
			$this->addError($nr);
		}
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
