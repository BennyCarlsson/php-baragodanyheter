<?php

Class AdminArticleObject{
	public $articleId;
	public $title;
	public $text;
	public $link;
	public $shortLink;
	public $anonymous;
	public $statusId;
	public $name;
	public $date;
	public $typeId;
	public $fileType;
	public $youtubeId;
	public $fileName;
	
	public function __construct($ArticleId, $Title, $Text, $Link, $Link_short_name, $Anonymous,$StatusId, $Name, $Date, $FileName, $TypeId, $TypeName){
		$this->articleId = $ArticleId;
		$this->title = $Title;
		$this->text = $Text;
		$this->link = $Link;
		$this->shortLink = $Link_short_name;
		$this->anonymous = $Anonymous;
		$this->statusId = $StatusId;
		$this->name = $Name;
		$this->date = $Date;
		$this->typeId = $TypeId;
		$this->fileType = $TypeName;
		$this->checkFileName($FileName);
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
	
	//takes the id out from the youtubelink to late make it into an embeded youttubelink
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
