<?php
session_start();
require_once "userPage/controller/mainController.php";
$mainController = new MainController();
$html = $mainController->startController();
echo $html;
