<?php
require_once 'adminDAL.php';
require_once 'adminArticleObject.php';


Class AdminArticleModel{
	private $DAL;
	public $adminArticleObject;	
	const statusPublished = 2;
	const statusDenied = 3;
	
	public function __construct(){
		$this->adminDAL = new AdminDAL();
	}
	
	public function setAdminArticleObject(){
		$this->adminArticleObject = $this->adminDAL->setAdminArticleObject();
	}
	
	public function acceptArticle($articleId){
		$this->adminDAL->changeArticleStatus($articleId, self::statusPublished);
	}
	public function denyArticle($articleId){
		$this->adminDAL->changeArticleStatus($articleId, self::statusDenied);
	}
}
