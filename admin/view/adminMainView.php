<?php

Class AdminMainView{
	private static $navRegister = "navRegister";
	private static $navPending = "navPending";
	private static $navPostArticle = "navPostArticle";
	private static $navAllArticles = "navAllArticles";
	private static $navUsers = "navUsers";
	
	public function getNavRegister(){
		if(isset($_GET[self::$navRegister])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNavPendingArticles(){
		if(isset($_GET[self::$navPending])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNavPostArticles(){
		if(isset($_GET[self::$navPostArticle])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNavAllArticles(){
		if(isset($_GET[self::$navAllArticles])){
			return TRUE;
		}
		return FALSE;
	}
	public function getNavUsers(){
		if(isset($_GET[self::$navUsers])){
			return TRUE;
		}
		return FALSE;
	}
	
	public function getAdminNavHTML(){
		if($this->getNavRegister()){
			$HTML = "<div id='adminNav'>
					<a href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a id='adminNavActive' href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a href=userpage.php?".self::$navUsers.">Användare</a>
				</div>
				";
		}else if($this->getNavPostArticles()){
			$HTML = "<div id='adminNav'>
					<a href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a id='adminNavActive' href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a href=userpage.php?".self::$navUsers.">Användare</a>
				</div>
				";
		}else if($this->getNavAllArticles()){
			$HTML = "<div id='adminNav'>
					<a href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a id='adminNavActive' href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a href=userpage.php?".self::$navUsers.">Användare</a>
				</div>
				";
		}else if($this->getNavUsers()){
			$HTML = "<div id='adminNav'>
					<a href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a id='adminNavActive' href=userpage.php?".self::$navUsers.">Användare</a>
				</div> 
				";
		}else if($this->getNavPendingArticles()){
			$HTML = "<div id='adminNav'>
					<a id='adminNavActive' href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a href=userpage.php?".self::$navUsers.">Användare</a>
				</div>
				";
		}else{
			$HTML = "<div id='adminNav'>
					<a href=userpage.php?".self::$navPending.">Köande Artiklar</a>
					<a href=userpage.php?".self::$navRegister.">Registrera användare</a>
					<a href=userpage.php?".self::$navPostArticle.">Skicka in artikel</a>
					<a href=userpage.php?".self::$navAllArticles.">Alla artiklar</a>
					<a href=userpage.php?".self::$navUsers.">Användare</a>
				</div>
				";
		}
		
		return $HTML;
	}
	
}
