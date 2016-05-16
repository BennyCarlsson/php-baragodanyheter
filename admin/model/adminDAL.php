<?php
require_once'db/db.php';
require_once 'common/commonDAL.php';


Class AdminDAL{
	private $db;
	private $DAL;
		
	public function __construct(){
		$this->db = new DB();
		$this->commonDAL = new CommonDAL();
	}
	public function addUser($mail,$password,$salt,$firstname,$lastname,$roleId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL addUser(?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("sssssi",$mail,$password,$salt,$firstname,$lastname,$roleId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	
	public function checkIfMailExist($mail){
		return $this->commonDAL->checkIfMailExist($mail);
	}
	
	public function setAdminArticleObject(){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getArticlesData()";
		if(($result = $mysqli->query($sql)) === FALSE){
			throw new Exception("'$sql' failed " . $mysqli->error);
		}
		$mysqli->close();
		$ret = array();
		while($obj = $result->fetch_object()){
			$name = $this->commonDAL->getNameOnId($obj->UserId);
			$ret[] = new adminArticleObject($obj->ArticleId, $obj->Title, $obj->Text, $obj->Link, 
			$obj->Link_short_name, $obj->Anonymous,$obj->StatusId, $name, $obj->Date, 
			$obj->Name, $obj->TypeId, $obj->TypeName);
		}
		return $ret;
	}
	public function getAllUsers(){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getAllUsers()";
		if(($result = $mysqli->query($sql)) === FALSE){
			throw new Exception("'$sql' failed " . $mysqli->error);
		}
		$mysqli->close();
		$ret = array();
		while($obj = $result->fetch_object()){
			$ret[] = new allUsersObject($obj->UserId, $obj->Mail, $obj->Firstname, $obj->Lastname, $obj->RoleName, $obj->RegDate);
		}
		return $ret;
	}
	public function changeArticleStatus($articleId, $status){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL changeArticleStatus(?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("ii",$articleId, $status) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	public function editArticle($id, $title, $text, $anonymous, $link, $shortLink, $statusId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL editArticle(?,?,?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("ississi",$id, $title, $text, $anonymous, $link, $shortLink, $statusId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
		
	}
	public function deleteArticle($id){
		$fileId = $this->getFileId($id);
		
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL deleteArticle(?)";
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
		$mysqli->close();

		$this->deleteFile($fileId);
	}
	private function getFileId($id){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getFileId(?)";
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
		$object = $result->fetch_object();
		$fileId = $object->FileId;
		$mysqli->close();
		return $fileId;
	}
	private function deleteFile($fileId){
		
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL deleteFile(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i",$fileId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	
	public function editFile($fileName, $articleId, $typeId){
		$fileId = $this->getFileId($articleId);
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL editFile(?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("isi",$fileId, $fileName, $typeId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	public function changePassword($password,$salt, $userId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL editPassword(?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("ssi",$password, $salt, $userId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	public function editUser($firstname,$lastname,$mail,$role,$userId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL editUser(?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("sssii",$firstname, $lastname, $mail, $role, $userId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$mysqli->close();
	}
	public function checkIfChangingMail($mail, $userId){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL checkIfMailExistOnId(?)";
		$stmt = $mysqli->prepare($sql);
		if($stmt === FALSE){
			throw new Exception("prepare of $sql failed" . $this->mysqli->error);
		}
		if($stmt->bind_param("i", $userId) === FALSE){
			throw new  Exception("bind_param of $sql failed " . $stmt->error);
		}
		if($stmt->execute() === FALSE){
			throw new Exception("execute of $sql failed " . $stmt->error);
		}
		$result = $stmt->get_result();
		$object = $result->fetch_object();
		$_mail = $object->Mail;
		if($mail == $_mail){
			$mysqli->close();
			return FALSE;
		}
		$mysqli->close();
		return TRUE;
		
		
	}
}

















