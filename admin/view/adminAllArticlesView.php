<?php
require_once 'common/commonView.php';

Class AdminAllArticlesView{
	private static $editBtn = 'editBtn';
	private static $editArticleId = 'editArticleId';
	private $commonView;
	private static $nrOfArticles = 'nrOfArticles'; 
	
	public function __construct(){
		$this->commonView = new CommonView();
	}
	public function checkIfEditArticle(){
		if(isset($_GET[self::$editBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getEditArticleId(){
		return $_GET[self::$editArticleId];
	}
	public function checkShowNrOfArticles(){
		if(isset($_POST[self::$nrOfArticles])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNrOfArticles(){
		return $_POST[self::$nrOfArticles];
	}
	public function getAllArticlesHTML($articleObject){
		$HTML = "";
		$HTML .= $this->getnrOfArticlesForm();
		$HTML .= $this->getAllArticles($articleObject);
		return $HTML;
	}
	
	private function getnrOfArticlesForm(){
		$HTML = "<form method='post' role='form' name='nrOfArticlesForm'>	
				<label for='".self::$nrOfArticles."'>Visa antal artiklar</label>
				<select name='".self::$nrOfArticles."'>";
		for($i = 1; $i <= 100; $i++) {
			if(isset($_POST[self::$nrOfArticles]) && $_POST[self::$nrOfArticles] == $i){
				$HTML .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else if(!isset($_POST[self::$nrOfArticles]) && $i == 5){
				$HTML .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
			}else{
				$HTML .= '<option value="'.$i.'">'.$i.'</option>';
			}
		}
		$HTML .= '<option value="101">Visa Alla</option>
				</select>
				<input type="submit" value="visa">
				</form>';
		return $HTML;
	}
	
	private function getAllArticles($articleObject){
		$HTML = "";
		$i = 0; 
		$y = 0; 
		foreach ($articleObject as $article) {
			if(isset($_POST[self::$nrOfArticles])){
				if($_POST[self::$nrOfArticles] == 101){ //show all articles
					$HTML .= $this->articleHTML($article);
				}
				else if($i < $_POST[self::$nrOfArticles]){
					$HTML .= $this->articleHTML($article);
					 $i++;
				}
			}else{
				if($y < 5){ //show 5 articles by default
					$HTML .= $this->articleHTML($article);		
					$y++;			
				}
			}	
		}
		return $HTML;
	}
	
	private function articleHTML($article){
		return "<div class='article'>
					<div class='articleTitle'>
						<h3>$article->title</h3>
					</div>
					<div class='articleFile'>"
						. $this->getFileHTML($article->fileType, $article->fileName) . //gets Image, Youtube or none HTML
					"</div>
					<div class='articleText'>
						<p>".nl2br($article->text)."</p>
						<div class='articleLink'>
							<a href='$article->link' target='_blank'>$article->shortLink</a>
						</div>
					</div>
					<p class='articleFooter'> Skriven av: $article->name $article->date </p>
					<form action='userpage.php' method='get' role='form' name='editArticleBtn'>		 
					<input type='hidden' value='".$article->articleId."' name='".self::$editArticleId."'>
					<input type='submit' name='".self::$editBtn."' value='Redigera'>
					</form>
				</div>";
	}
	
	
	private function getFileHTML($fileType, $fileName){
		return $this->commonView->getFileHTML($fileType, $fileName);
	}
}
