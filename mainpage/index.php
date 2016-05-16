<?php 
require_once 'mainPageController.php';
$controller = new MainPageController();
$HTML = $controller->getHTML();
echo $HTML;
