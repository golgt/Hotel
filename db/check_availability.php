<?php 
require_once "../classes/ReservationController.php";

$controller = new ReservationController();
$controller->handleRequest($_POST);
?>