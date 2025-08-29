<?php
header("Content-Type: application/json");
session_start();

require_once "../classes/Database.php";
require_once "../classes/ReservationService.php";
require_once "../classes/Validator.php";

$db = new Database();
$pdo = $db->getConnection();

$reservationService = new ReservationService($pdo);

// Získanie ID prihláseného používateľa (ak existuje)
$userId = $_SESSION['user_id'] ?? null;

// Spracovanie rezervácie a získanie odpovede
$response = $reservationService->makeReservation($_POST, $userId);

echo json_encode($response);
?>
