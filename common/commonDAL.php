<?php
require_once'./db/db.php';

Class commonDAL{
	private $db;
	
	public function __construct(){
		$this->db = new DB();
	}
	
	public function getNameOnId($id){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getNameOnId(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i",$id) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		
		$result = $stmt->get_result();
		$object = $result->fetch_array(MYSQLI_ASSOC);
		$name = $object['Firstname'] . " " . $object['Lastname'];
		$mysqli->close();
		return $name;
	}
	
	public function checkIfMailExist($mail){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL checkIfMailExists(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("s",$mail) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		if($result->num_rows >= 1){
			$mysqli->close();
			return TRUE;
		}
		$mysqli->close();
		return FALSE;
	}
}
