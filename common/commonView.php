<?php

Class CommonView{
	
	public function getFileHTML($fileType, $fileName){
		switch ($fileType) {
			case 'Image':
					$HTML = "<img src='pics/$fileName' alt='picture' class='img-responsive' >";
				break;
			case 'Youtube':
					$HTML = "<div class='embed-responsive embed-responsive-16by9'>
								<iframe width='420' height='315' src='http://www.youtube.com/embed/$fileName'> </iframe>
							</div>"; 
							//class='embed-responsive embed-responsive-16by9
				break;
			case 'None': 
					$HTML = "";
				break;
			default:
					$HTML = "";
				break;
		}
		return $HTML;
	}
}
