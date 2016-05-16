<?php

Class ArticleObject{
	public $title;
	public $file;
	public $text;
	public $journalist;
	public $date;
	public $fileName;
	public $fileType; //Image,Youtube,None
	public $link;
	public $shortLink;
	private $youtubeId;
	public $status;
	private static $anonymousJournalist = "Den Glada Journalisten";
	
	public function __construct($title, $file, $text, $journalist, $date, $fileName, $fileType, $anonymous, $link, $shortLink, $status){
		$this->title = $title;
		$this->file = $file;
		$this->text = $text;
		$this->date = $date;
		$this->fileType = $fileType;
		$this->checkAnonymous($journalist, $anonymous);
		$this->checkFileName($fileName);
		$this->link = $link;
		$this->shortLink = $shortLink;
		$this->status = $status;
	}
	private function checkAnonymous($journalist, $anonymous){
		if($anonymous == 1){
			$this->journalist =self::$anonymousJournalist;
		}else{
			$this->journalist = $journalist;
		}
	}
	private function checkFileName($fileName){
		if($this->fileType == "Youtube"){
			if($this->youtubeEmbed($fileName)){
				$this->fileName = $this->youtubeId;
			}else{
				$this->fileName = "Kan inte hitta youtubeklippet";
			}
		}else{
			$this->fileName = $fileName;
		}
	}
	
	//get the youtube id from the youtubelink to later make it into an embededed youtubelink
	private function youtubeEmbed($fileName){
		$url = $fileName;
		 preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $url,
        $matches
    	);
		if(empty($matches[1])){
			return FALSE;
		}
		$this->youtubeId = $matches[1];
    	return TRUE;
	}
	
}