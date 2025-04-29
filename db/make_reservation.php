<?php
header("Content-Type: application/json");
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    //databáza z formulára
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = $_POST['guests'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    // Validácia
    if (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests) || empty($name) || empty($surname) || empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Chýbajú údaje v rezervácii.'
        ]);
        exit;
    }
    //prevod dátumov pre výpočet bodov
    $checkInDate = new DateTime($checkIn);
    $checkOutDate = new DateTime($checkOut);
    $nights = $checkInDate->diff($checkOutDate)->days;

    $pdo->beginTransaction();
    //vloženie rezervácie
    $stmt = $pdo->prepare("INSERT INTO reservations (name, surname, email, guests, room_id, start_date, end_date, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->execute([$name, $surname, $email, $guests, $roomId, $checkIn, $checkOut]);

    $successMessage = 'Rezervácia bola úspešne uložená!';

    //ak je užívatel prihlásený pripočítajú sa body
    if(isset($_SESSION['user_id'])){
        $userId = $_SESSION['user_id'];
        $pointsToAdd = $nights * 10;

        $updatePoints = $pdo->prepare("UPDATE users SET loyalty_points = loyalty_points + ? WHERE id = ?");
        $updatePoints->execute([$pointsToAdd, $userId]);

        $successMessage .= " Získali ste $pointsToAdd vernostných bodov.";
    }
    //potvrdenie transakcie
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => $successMessage
    ]);

} catch (Exception $e) {
    //zrušenie transakcie v prípade chyby
    if($pdo->inTransaction()){
        $pdo->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => 'Chyba pri ukladaní rezervácie: ' . $e->getMessage()
    ]);
}
