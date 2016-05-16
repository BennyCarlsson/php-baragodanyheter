<?php
//TODO error message

Class UploadPic{
	public $fileName;
	private $direction = 'pics/';
	const maxSize = 5024001; //Max 5mb 
	
	public function uploadImage($pic, $title){
		if(!$pic['error']){
			if($this->checkFileSize($pic)){
				$this->setPicName($title, $pic['type']);
				$decodedFilename = $this->fileName;
				move_uploaded_file($pic['tmp_name'], $this->direction . $decodedFilename);
				return TRUE;
			}
			
		}
		return FALSE;
	}
	
	public function checkFileType($pic){
		if($pic['type'] == 'image/jpeg' ||
			$pic['type'] == 'image/jpg' ||
			$pic['type'] == 'image/png'){
				return TRUE;
			}
		return FALSE;
	}
	private function setPicName($title, $type){
		$type = str_replace("image/", ".", $type);
		$title = str_replace(":)", "-",$title);
		$title = str_replace("%", "-",$title);
		$title = str_replace('"', "-",$title);
		$title = str_replace('&', "-",$title);
		$picName = str_replace(" ", "-",$title);
		$_picName = $picName;
		$picName .= $type;
		$i = 1;
		while(file_exists($this->direction . $picName)){
			$i++;
			$picName = $_picName. $i . $type;
		}
		$this->fileName = $picName;
	}
	public function checkFileSize($pic){
		if($pic['size'] < self::maxSize){
			return TRUE;
		}
		return FALSE;
	}
}
