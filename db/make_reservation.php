<?php
header("Content-Type: application/json");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $roomId = $_POST['room_id'];
    $checkIn = $_POST['check_in'];
    $checkOut = $_POST['check_out'];
    $guests = $_POST['guests'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];

    // Validácia - môžeš pridať viac
    if (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests)) {
        echo json_encode([
            'success' => false,
            'message' => 'Chýbajú údaje v rezervácii.'
        ]);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO reservations (name, surname, email, guests, room_id, start_date, end_date, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->execute([$name, $surname, $email, $guests, $roomId, $checkIn, $checkOut]);

    echo json_encode([
        'success' => true,
        'message' => 'Rezervácia bola úspešne uložená!'
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Chyba pri ukladaní rezervácie: ' . $e->getMessage()
    ]);
}
