<?php

Class PendingArticleView{
	private static $acceptPendingBtn = 'acceptPendingBtn';
	private static $deniedPendingBtn = 'deniedPendingBtn';
	private static $pendingArticleValue = 'pendingArticleValue';
	
	public function getAcceptPendingBtn(){
		if(isset($_POST[self::$acceptPendingBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getDeniedPendingBtn(){
		if(isset($_POST[self::$deniedPendingBtn])){
			return TRUE;
		}
		return FALSE;
	}
	public function getPendingArticleId(){
		return $_POST[self::$pendingArticleValue];
	}
	
	public function getPendingArticlesHTML($adminArticleObject){
		$HTML = "<h3>Väntande Artiklar!</h3>";
		$noArticles = TRUE;
		foreach ($adminArticleObject as $article) {
			if($article->statusId == 1){
				$noArticles = FALSE;
				$HTML .= $this->articleHTML($article);	
			}
		}
		if($noArticles){
			$HTML .= "<h4>Inga nya Artiklar!</h4>";
		}
		return $HTML;
	}
	
	private function articleHTML($article){
		$HTML = "";
		$HTML .= "<div class='article'>
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
					<form method='post' role='form' >		
						<input type='hidden' name='".self::$pendingArticleValue."' value='$article->articleId'>
						<input type='submit' class='btn btn-primary btn-lg' name='".self::$acceptPendingBtn."' id='acceptPendingBtn' value='Acceptera'>
						<input type='submit' class='btn btn-primary btn-lg' name='".self::$deniedPendingBtn."' id='deniedPendingBtn' value='Neka'>
					</form>			 
				</div>";
		
		return $HTML;
	}
	
	private function getFileHTML($fileType, $fileName){
		switch ($fileType) {
			case 'Image':
					$HTML = "<img src='../pics/$fileName' alt='picture' class='img-responsive' >";
				break;
			case 'Youtube':
					$HTML = "<div class='embed-responsive embed-responsive-16by9'>
								<iframe width='420' height='315' src='http://www.youtube.com/embed/$fileName'> </iframe>
							</div>"; 
							//class='embed-responsive embed-responsive-16by9
				break;
			case 'None': 
					$HTML = "";
				break;
			default:
					$HTML = "";
				break;
		}
		return $HTML;
	}
}
