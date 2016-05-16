<?php
require_once 'mainPageDAL.php';
require_once 'articleObject.php';

Class MainPageModel{
	private $mainPageDAL;	
	public $articlar;
	public $articleObject;
		
	public function __construct(){
		$this->mainPageDAL = new MainPageDAL(); 
	}
	public function getArticles(){
		$this->articleObject = $this->mainPageDAL->getAllArticles();
	}
}
