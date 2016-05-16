<?php
require_once'db/db.php';
require_once 'common/commonDAL.php';

Class MainPageDAL{
	private $db;
	private $fileName;
	private $fileType;
	private $commonDAL;
	public function __construct(){
		$this->db = new DB();
		$this->commonDAL = new CommonDAL();
	}
	
	public function getAllArticles(){
		$mysqli = $this->db->getDbConnection();
		$sql = "CALL getArticlesData()";
		if(($result = $mysqli->query($sql)) === FALSE){
			throw new Exception("'$sql' failed " . $mysqli->error);
		}
		$mysqli->close();
		$ret = array();
		while($obj = $result->fetch_object()){
			$journalist = $this->commonDAL->getNameOnId($obj->UserId);
			$ret[] = new ArticleObject($obj->Title, $obj->FileId, $obj->Text, $journalist, $obj->Date, $obj->Name,
			$obj->TypeName, $obj->Anonymous, $obj->Link, $obj->Link_short_name, $obj->StatusId);
		}
		
		return $ret;
	}

}















