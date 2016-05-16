<?php

Class MainView{
	private static $logout = 'logout';
	public function checkLogOutButton(){
		if(isset($_GET[self::$logout])){
			return TRUE;
		}
		return FALSE;
	}
	public function getFirstHTML(){
		$HTML = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'
				'http://www.w3.org/TR/html4/loose.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
	    			<head>
	    				<link href='css/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
			        	<link rel='stylesheet' type='text/css' href='css/userpage.css'>
			        	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
			        	<title>Bara Goda Nyheter</title>
			        	<link rel='icon' type='image/ico' href='../pics/logga.png'/>
				    </head>
				    <header>
				    	<h1>Bara Goda Nyheter!</h1>
				    </header>
				    <body>
						<div id='content'>
						<div id='mainViewError'>
						</div>";
		return $HTML;
	}
	
	//if account is frozen
	public function getFrozenHTML(){
		return "<h3>DITT KONTO HAR BLIVIT FRYST! KONTAKTA ADMIN FÖR MER INFORMATION!</h3>";
	}
	public function getLogoutHTML(){
		$HTML = "
			<a id='logoutBtn' href='userpage.php?".self::$logout."'>Logga ut</a>
		";
		return $HTML;
	}
	public function getLastHTML(){
			$HTML ="</div>
					</body>
				    <footer>	    	
				    </footer>
				</html>";
		return $HTML;
	}
}
