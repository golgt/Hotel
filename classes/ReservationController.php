<?php
require_once "Database.php";
require_once "ReservationCheck.php";
class ReservationController {
    private Reservation $reservation;

    public function __construct() {
        $db = new Database();
        $pdo = $db->getConnection();
        $this->reservation = new Reservation($pdo); // Inicializácia rezervácie
    }

   
    public function handleRequest(array $data): void {
        header("Content-Type: application/json");

        // Získanie a validácia vstupných údajov
        $roomId = (int)($data['room_id'] ?? 0);
        $checkIn = $data['check_in'] ?? '';
        $checkOut = $data['check_out'] ?? '';

        // Kontrola či boli poskytnuté všetky potrebné údaje
        if (!$roomId || !$checkIn || !$checkOut) {
            echo json_encode([
                'available' => false,
                'message' => 'Neplatné údaje.'
            ]);
            return;
        }

        // Kontrola dostupnosti izby v požadovanom termíne
        if ($this->reservation->isAvailable($roomId, $checkIn, $checkOut)) {
            echo json_encode([
                'available' => true,
                'message' => 'Izba je dostupná v požadovanom termíne.'
            ]);
        } else {
            // Ak izba nie je dostupná, nájde najbližší dostupný termín
            $nextDate = $this->reservation->nextAvailableDate($roomId);
            echo json_encode([
                'available' => false,
                'message' => "Izba nie je dostupná. Najbližší dostupný termín je od $nextDate."
            ]);
        }
    }
}
