<?php
require_once 'db/db.php';
require_once 'common/commonDAL.php';

Class DAL{
	private $db;
	private $commonDAL;
	
	public function __construct(){
		$this->db = new DB();
		$this->commonDAL = new CommonDAL();
	}
	
	//returns true if mail exists
	public function checkIfMailExist($mail){
		return $this->commonDAL->checkIfMailExist($mail);
	}
	
	public function compareMailAndPassword($mail, $password){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL checkMailAndPassword(?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("ss",$mail,$password) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$mysqli->close();
		if($result->num_rows >= 1){
			return TRUE;
		}
		return FALSE;
	}
	public function getDBPassword($mail){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getPasswordOnMail(?)";
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
		$mysqli->close();
		$object = $result->fetch_array(MYSQLI_ASSOC);
		return $object['Password'];
	}
	
	public function getSaltOnMail($mail){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getSaltOnMail(?)";
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
		$mysqli->close();
		$object = $result->fetch_array(MYSQLI_ASSOC);
		return $object['salt'];
	}
	public function setUserData($mail){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getUserDataOnMail(?)";
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
		$mysqli->close();
		$object = $result->fetch_array(MYSQLI_ASSOC);
		
		return new UserObject($object['UserId'],$object['Mail'],$object['Firstname'],$object['Lastname'],$object['RoleId']);
		
	}
	
	//addFile2 used instead since insert_id didn't work with stored procedure
	public function addFile($name, $typeId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL addFile(?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("si",$name, $typeId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$stmt -> store_result();
		$stmt -> fetch();
		$id = $stmt -> insert_id;
		$mysqli->close();
		return $id;
	}
	
	//insert_id does not work with stored procedure ($this->addFile)
	public function addFile2($name, $typeId){
			$mysqli = $this->db->getDbConnection();
			$insertSql = "INSERT INTO file(Name, TypeId) VALUES (?,?)";
			$stmt = $mysqli -> prepare($insertSql);
			$stmt -> bind_param("si", $name,$typeId);
			$stmt -> execute();
			
			$stmt -> store_result();
			$stmt -> fetch();
			$id = $stmt -> insert_id;
			$mysqli->close();
			return $id;
	}
	public function addArticle($fileId, $title, $text, $link, $linkShortName, $anonymous, $status, $userId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL addArticle(?,?,?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("isssiiis",$fileId,$title,$text,$link,$anonymous,$userId,$status,$linkShortName) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	
	public function checkIfTitleExist($title){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL checkIfTitleExists(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("s",$title) === FALSE){
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

















