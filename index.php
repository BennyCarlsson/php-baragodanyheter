<?php 
require_once 'mainpage/mainPageController.php';
$controller = new MainPageController();
$HTML = $controller->getHTML();
echo $HTML;
