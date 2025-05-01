<?php 
require_once "../classes/ReservationCheck.php";

$pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8","root","",[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION                                                                          //pripaja k databaze  
]);

$reservation = new Reservation($pdo);

$roomId = (int)$_POST['room_id'];
$checkIn = $_POST['check_in'];
$checkOut = $_POST['check_out'];

header("Content-Type: application/json");

if($reservation->isAvailable($roomId, $checkIn, $checkOut)) {                          //ak je datum dostupny rezervacia je ulozena ak nie vypise datum kedy je najblizsie dostupne
    echo json_encode([
        'available' => true,
        'message' => 'Izba je dostupná v požadovanom termíne.'
    ]);
} else {
    $nextDate = $reservation->nextAvailableDate($roomId);
    echo json_encode([
        'available' => false,
        'message' => "Izba nie je dostupná. Najbližší dostupný termín je od $nextDate."
    ]);
}
?>