<?php

Class MainPageView{
	private $mainPageModel;
	private static $article = 'article';
	const articlesPerPage = 5;
	const maxPages = 100;
	private static $about = 'OmBaraGodaNyheter';
	private $fbMeta;
	
	//checks if someone pressed an article
	//returns bool
	public function checkGetArticle(){
		if(isset($_GET[self::$article])){
			return TRUE;
		}
		return FALSE;
	}
	
	//gets the pagenumber else retuns page 1
	public function getPageNr(){
		if(isset($_GET['p'])){
			return $_GET['p'];
		}else{
			return 1;
		}
	}
	
	public function checkAboutBtn(){
		if(isset($_GET[self::$about])){
			return TRUE;
		}
		return FALSE;
	}
	
	private function getFirstHTML($fbMetaTag){
		$HTML = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
				'http://www.w3.org/TR/html4/loose.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
	    			<head>
			        	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			        	<meta name='description' content='Bara Goda Nyheter, En sida som samlar alla goda nyheter'/>
			        	<meta name='keywords' content='bara goda nyheter, bra nyheter, glada nyheter, nyheter, svenska'/>
			        	<title>Bara Goda Nyheter</title>
			        	<link href='css/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
			        	<link rel='stylesheet' type='text/css' href='css/homepage.css'>
			        	<link rel='icon' type='image/ico' href='pics/logga.png'/>
			        	".$this->getGoogleAnalytic()."
			        	".$fbMetaTag."
				    </head>
				    <body>";
		$HTML .= '<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.0";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, "script", "facebook-jssdk"));</script>';
		
		$HTML .="	 <header>
				    	<h1><a href=index.php>Bara Goda Nyheter</a></h1>
				    	";
		
		return $HTML;
	}
	private function getGoogleAnalytic(){
		return "<script>
			  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			  ga('create', 'UA-56345562-1', 'auto');
			  ga('send', 'pageview');
			
			</script>";
	}
	private function getMainFBMetaTag(){
		
		return 			"<meta property='og:title' content='BaraGodaNyheter.se' />
						<meta property='og:site_name' content='http://baragodanyheter.se'/>
						<meta property='og:url' content='http://baragodanyheter.se/index.php' />
						<meta property='og:description' content='En hemsida med bara goda nyheter.' />
						<meta property='og:image' content='http://baragodanyheter.se/pics/logga.png'/>
						<meta property='og:image:type' content='image/png'/>";
	}
	private function getOneArticleFBMetaTag($article){
						$text = str_replace('"', "'", $article->text);
						$title = urlencode($_GET[self::$article]);
		return 			'<meta property="og:title" content="'.$article->title.'" />
						<meta property="og:site_name" content="http://baragodanyheter.se"/>
						<meta property="og:type" content="article"/>
						<meta property="og:url" content="http://baragodanyheter.se/index.php?article='.$title.'" />
						<meta property="og:description" content="'.$text.'" />
						<meta property="og:image" content="http://baragodanyheter.se/pics/'.$article->fileName.'"/>
						';
						//
						//<meta property='og:video' content='http://www.youtube.com/v/$article->fileName'/>
	}
	//return string facebook like button
	private function getFbLikeBtn(){
		return "<div id='fbLikeBtn'>
				    	<iframe src='//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FBaragodanyheterse%2F1485529451730692%3Fref%3Daymt_homepage_panel&amp;width=500&amp;height=62&amp;colorscheme=light&amp;show_faces=false&amp;header=true&amp;stream=false&amp;show_border=true' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:500px; height:62px;' allowTransparency='true'></iframe>
				    	</div>";
	}
	//return string twitter follow button
	private function getTwitterFollowBtn(){
		return "<div id='twitterFollowBtn'>
				<a href='https://twitter.com/GodaNyheterSE' class='twitter-follow-button' data-show-count='false' data-size='large' data-show-screen-name='false'>Follow @_GodaNyheter</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				</div>";
	}
	//return string HTML alla articles
	public function getArticles($articlesObjekt, $pageNr){
		$fbMetaTag = $this->getMainFBMetaTag();
		$HTML = "
				".$this->getFirstHTML($fbMetaTag)."
				<div id='menuNav'>
		    		<a id='menuNavActive' href='index.php'>Senaste Artiklar</a>
		    		<a class='aboutNav'href='index.php?OmBaraGodaNyheter'>Om Bara Goda Nyheter</a>
		    		".$this->getFbLikeBtn().$this->getTwitterFollowBtn().
	    			"</header>
	    		</div><div id='content'>";
				
		//gets the articles according to the pagenumber
		$firstArticle = (($pageNr-1) * self::articlesPerPage + 1);
		$lastArticle =  ($pageNr * self::articlesPerPage);
		$i = 1;
		if($pageNr > self::maxPages || $pageNr < 0){
			$HTML .= $this->getNoArticlesHereHTML();
		}else{
			foreach ($articlesObjekt as $article) {
				if($article->status == 2){ 
					if($i >=  $firstArticle && $i <= $lastArticle ){
						$HTML .= $this->articleHTML($article);	
					}
					$i++;
				}
			}
		}
		return $HTML;
	}
	
	public function getTheArticle($articlesObjekt){
		$HTML = "";
		foreach ($articlesObjekt as $article) {
			$title1 = urlencode($article->title);
			$title2 = urlencode($_GET[self::$article]);
			if($title1 === $title2){
				$HTML .=$this->getTheArticleHeader($article);
				$HTML .=$this->setFbShareMetaTag($article);
				$HTML .= $this->articleHTML($article);	
			}
		}
		$HTML .= "<h3> <a href='index.php'> >>Läs Mer Goda Nyheter!<< </a></h3>";
		
		return $HTML;
	}
	private function getTheArticleHeader($article){
		$fbMetaTag = $this->getOneArticleFBMetaTag($article);
		$HTML = "
					".$this->getFirstHTML($fbMetaTag)."
					<div id='menuNav'>
		    		<a href='index.php'>Senaste Artiklar</a>
		    		<a class='aboutNav'href='index.php?OmBaraGodaNyheter'>Om Bara Goda Nyheter</a>
		    		".$this->getFbLikeBtn().$this->getTwitterFollowBtn()."
	    		</div>
	    		</header>
				<div id='content'>";
		return $HTML;
	}
	private function setFbShareMetaTag($article){
		$this->fbMeta = '';
	}
	private function articleHTML($article){
		$HTML = "";
		if($article->status == 2){
			$hrefTitle = urlencode($article->title); 
			$HTML .= "<article>
						<div class='article'>
							<div class='articleTitle'>
								<h3><a href='index.php?article=$hrefTitle' target='_blank'> $article->title </a></h3>
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
							<p class='articleFooter'> Skriven av: $article->journalist $article->date </p>				 
						</div>
						</article>";
		}
		return $HTML;
	}
	
	private function getFileHTML($fileType, $fileName){
		switch ($fileType) {
			case 'Image':
					$HTML = "<img src='pics/$fileName' alt='picture' class='img-responsive' >";
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
	public function getAboutHTML(){
		$fbMetaTag = $this->getMainFBMetaTag();
		$HTML = "
					".$this->getFirstHTML($fbMetaTag)."
					<div id='menuNav'>
		    		<a  href='index.php'>Senaste Artiklar</a>
		    		<a id='menuNavActive' class='aboutNav'href='index.php?OmBaraGodaNyheter'>Om Bara Goda Nyheter</a>
		    		".$this->getFbLikeBtn().$this->getTwitterFollowBtn()."
	    		</div>
	    		</header>
				<div id='content'>
				<div class='article'>
					<div class='articleTitle'>
						<h3><a href='index.php'> Bara Goda Nyheter! </a></h3>
					</div>
					<div class='articleText'>
						<p>BaraGodaNyheter.se är en sida där vi sammlar alla goda och glada nyheter.</p>
						<p>Sidan är till för dej som tröttnar på att dagligen bara får höra om alla hemska saker som händer i världen,</p>
						<p>För det finns massor med bra och goda saker som händer runt omkring oss hela tiden vi måste bara se dom!</p>
						<div class='articleLink'>
							<a href='index.php'>BaraGodaNyheter.se</a>
						</div>
					</div>
					<p class='articleFooter'> Sidan skapad av: Benny Carlsson </p>				 
				</div>
				
				<div id='content'>
				<div class='article'>
					<div class='articleTitle'>
						<h3><a href='index.php'>Kontakt </a></h3>
					</div>
					<div class='articleText'>
						<p>Vill du kontakta ansvarig för sidan eller har du tips om nyheter?</p>
						<p>Maila Benny Carlsson</p> Mail: <img src='pics/mail.jpg' alt='mail' id='mailPic' >
						</br>
						<div class='articleLink'>
							<a href='index.php'>BaraGodaNyheter.se</a>
						</div>
					</div>
					<p class='articleFooter'> Sidan skapad av: Benny Carlsson </p>				 
				</div>
				";
		return $HTML;
	}
	public function getNavHTML($pageNr){
		$HTML = "<div class='nav'>";
		
		
		$nr = $pageNr;
		for ($i=0; $i < 5; $i++) {
			if($i == 0 && $pageNr != 1){
				$previousPage = $pageNr - 1;
				$HTML .="<a href='?p=$previousPage'> <.. </a>
						 <a class='navActive' href='?p=$nr'> $nr </a>";
			}else if($i == 0 && $pageNr == 1){
				$HTML .="<a class='navActive' href='?p=$nr'> $nr </a>";
			}
			else if($i == 4){
				$HTML .= "<a href='?p=$nr'> $nr.. </a>";
			}else{
				$HTML .= "<a href='?p=$nr'> $nr </a>";
			}
			$nr++;	
		}
		$nextPage = $pageNr + 1;	
		$HTML .="<a class='navNext' href='?p=$nextPage'> nästa>></a>
				</div>";
		return $HTML;
	}
	
	private function getNoArticlesHereHTML(){
		$HTML = "
		<div class='article'>
		<h3><a href='index.php'>There's no articles here you fool </a></h3>
		</div>
				";
			
		return $HTML;
	}
	public function getLastHTML(){
			$HTML ="
					</div>
					</body>
				    <footer>	    	
				    </footer>
				</html>";
		return $HTML;
	}
}
