<?php
header("Content-Type: application/json");
session_start();

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Dáta z formulára
    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = (int) $_POST['guests'];
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $discountValue = isset($_POST['discount_value']) ? (float) $_POST['discount_value'] : 0;

    // Validácia prázdnych polí
    if (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests) || empty($name) || empty($surname) || empty($email)) {
        echo json_encode([
            'success' => false,
            'message' => 'Chýbajú údaje v rezervácii.'
        ]);
        exit;
    }

    // Validácia emailu
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'success' => false,
            'message' => 'Neplatná e-mailová adresa.'
        ]);
        exit;
    }

    // Validácia počtu hostí
    if ($guests <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Neplatný počet osôb.'
        ]);
        exit;
    }

    // Prevod a kontrola dátumov
    $checkInDate = new DateTime($checkIn);
    $checkOutDate = new DateTime($checkOut);
    if ($checkInDate >= $checkOutDate) {
        echo json_encode([
            'success' => false,
            'message' => 'Dátum odchodu musí byť po dátume príchodu.'
        ]);
        exit;
    }

    $nights = $checkInDate->diff($checkOutDate)->days;

    // Načítaj cenu izby
    $stmt = $pdo->prepare("SELECT price FROM rooms WHERE id = ?");
    $stmt->execute([$roomId]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$room) {
        echo json_encode([
            'success' => false,
            'message' => 'Izba sa nenašla.'
        ]);
        exit;
    }

    $pricePerNight = $room['price'];
    $totalPrice = $nights * $pricePerNight;
   
    // Začiatok transakcie
    $pdo->beginTransaction();

    
    // Uloženie rezervácie s cenou
    $stmt = $pdo->prepare("INSERT INTO reservations (name, surname, email, guests, room_id, start_date, end_date, total_price, discount_value, created_at)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $surname, $email, $guests, $roomId, $checkIn, $checkOut, $totalPrice, $discountValue]);


    $successMessage = "Rezervácia bola úspešne uložená! Celková cena: $totalPrice €.";

    // Vernostné body
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $pointsToAdd = $nights * 5;

        $updatePoints = $pdo->prepare("UPDATE users SET loyalty_points = loyalty_points + ? WHERE id = ?");
        $updatePoints->execute([$pointsToAdd, $userId]);

        $successMessage .= " Získali ste $pointsToAdd vernostných bodov.";
    }

    // Potvrdenie transakcie
    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => $successMessage
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode([
        'success' => false,
        'message' => 'Chyba pri ukladaní rezervácie: ' . $e->getMessage()
    ]);
}
