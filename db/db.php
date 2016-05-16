<?php

Class DB{
	private $con;
	
	/*public function getCon(){
		$this->con = mysqli_connect($host, $user, $password, $database, $port, $socket);
		if(mysqli_connect_errno()){
			die(mysqli_connect_error());
		}
		return $this->con;
	}
	 * 
	 */
	 
	 public function getDbConnection(){
	 	$mysqli = new \mysqli("ip","username","password", "db");
		if ($mysqli->connect_errno) {
		    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		return $mysqli;
	 }
}
