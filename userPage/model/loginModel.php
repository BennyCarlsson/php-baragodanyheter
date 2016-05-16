<?php
require_once 'hashAndSalt.php';
require_once 'DAL.php';
require_once 'userObject.php';

Class LoginModel{
	private static $loggedInSession = "loggedInSession";
	private static $mailSession = "mailSession";
	private static $sessionSecurity = "session_security";
	private static $browser = "webbläsare";
	private $DAL;
	private $hashAndSalt;
	public $messageNR = array();
	public $userObject;
	
	public function __construct(){
		$this->hashAndSalt = new HashAndSalt();
		$this->DAL = new DAL();
	}
	
	public function tryLogin($mail, $password){
		if($this->modelCheck($mail, $password)){
			if($this->compareMailAndPassword($mail, $password)){
				$this->createLoggedInSession($mail);
				$this->setUserObject();
				return TRUE;
			}
			$this->addMessageNR(1);
			return FALSE;
		}
		return FALSE;
	}
	
	private function setUserObject(){
		$this->userObject = $this->DAL->setUserData($_SESSION[self::$mailSession]);
	}
	
	private function modelCheck($mail, $password){
		$check = TRUE;
		if(empty($mail)||empty($password)){
			$check = FALSE;
			$this->addMessageNR(2);
		}
		if($this->stripInput($mail)||$this->stripInput($password)){
			$check = FALSE;
			$this->addMessageNR(3);
		}
		return $check;
	}
	
	private function compareMailAndPassword($mail,$password){
		if($this->DAL->checkIfMailExist($mail)){
			$salt = $this->DAL->getSaltOnMail($mail);
			$hashedPassword = $this->hashAndSalt->getHashedPassword($password, $salt);
			if($this->DAL->compareMailAndPassword($mail,$hashedPassword)){ 
				return TRUE;
			}
			return FALSE;	
		}
		return FALSE;
	}
	
	private function stripInput($input){
		$strippedInput = strip_tags($input);
		if($input === $strippedInput){
			return FALSE;
		}
		return TRUE;
	}
	private function addMessageNR($nr){
		$this->messageNR[] = $nr;
	}
	public function checkIfLoggedIn(){
		if(isset($_SESSION[self::$loggedInSession])){
			if($this->checkSession()){
				$this->setUserObject();
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	private function checkSession(){
		if($_SESSION[self::$sessionSecurity][self::$browser] === $this->getUserAgent()){
			return TRUE;
		}
		return FALSE;
	}
	private function createLoggedInSession($mail){
		$_SESSION[self::$loggedInSession] = TRUE;
		$_SESSION[self::$mailSession] = $mail;
		$_SESSION[self::$sessionSecurity] = array();
		$_SESSION[self::$sessionSecurity][self::$browser] = $this->getUserAgent();	
	}
	public function logOut(){
		unset($_SESSION[self::$loggedInSession]);
		session_destroy();
		header("location:index.php");
		exit();
	}
	
	// Magic happens in this function to find out the users browser
    //http://stackoverflow.com/questions/9693574/user-agent-extract-os-and-browser-from-string-php
	private static function getUserAgent(){
    	static $agent = null;
	    if ( empty($agent) ) {
	        $agent = $_SERVER['HTTP_USER_AGENT'];
	
	        if ( stripos($agent, 'Firefox') !== false ) {
	            $agent = 'firefox';
	        } elseif ( stripos($agent, 'MSIE') !== false ) {
	            $agent = 'ie';
	        } elseif ( stripos($agent, 'iPad') !== false ) {
	            $agent = 'ipad';
	        } elseif ( stripos($agent, 'Android') !== false ) {
	            $agent = 'android';
	        } elseif ( stripos($agent, 'Chrome') !== false ) {
	            $agent = 'chrome';
	        } elseif ( stripos($agent, 'Safari') !== false ) {
	            $agent = 'safari';
	        } elseif ( stripos($agent, 'AIR') !== false ) {
	            $agent = 'air';
	        } elseif ( stripos($agent, 'Fluid') !== false ) {
	            $agent = 'fluid';
	        }
	
	    }
	    return $agent;
	}
}
