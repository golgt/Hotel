<?php
class ReservationService {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getRoomPrice(int $roomId): ?float {
        $stmt = $this->pdo->prepare("SELECT price FROM rooms WHERE id = ?");
        $stmt->execute([$roomId]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        return $room ? (float)$room['price'] : null;
    }

    public function makeReservation(array $data, ?int $userId = null): array {
        // Validácia vstupov
        $errors = Validator::validateReservationData($data);
        if ($errors) {
            return ['success' => false, 'message' => implode(' ', $errors)];
        }

        // Výpočet nocí
        $checkInDate = new DateTime($data['check_in']);
        $checkOutDate = new DateTime($data['check_out']);
        $nights = $checkInDate->diff($checkOutDate)->days;

        // Získanie ceny izby
        $pricePerNight = $this->getRoomPrice((int)$data['room_id']);
        if ($pricePerNight === null) {
            return ['success' => false, 'message' => 'Izba sa nenašla.'];
        }

        $totalPrice = $nights * $pricePerNight;
        $discountValue = isset($data['discount_value']) ? (float)$data['discount_value'] : 0;

        try {
            $this->pdo->beginTransaction();

            // Vloženie rezervácie
            $stmt = $this->pdo->prepare("INSERT INTO reservations 
                (name, surname, email, guests, room_id, start_date, end_date, total_price, discount_value, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

            $stmt->execute([
                $data['name'],
                $data['surname'],
                $data['email'],
                (int)$data['guests'],
                (int)$data['room_id'],
                $data['check_in'],
                $data['check_out'],
                $totalPrice,
                $discountValue
            ]);

            $successMessage = "Rezervácia bola úspešne uložená! Celková cena: $totalPrice €.";

            // Vernostné body (ak prihlásený)
            if ($userId !== null) {
                $pointsToAdd = $nights * 5;
                $usedPoints = isset($data['used_points']) ? (int)$data['used_points'] : 0;

                $updatePoints = $this->pdo->prepare("
                    UPDATE users 
                    SET loyalty_points = GREATEST(loyalty_points - ?, 0) + ? 
                    WHERE id = ?
                ");
                $updatePoints->execute([$usedPoints, $pointsToAdd, $userId]);

                $successMessage .= " Získali ste $pointsToAdd vernostných bodov.";
                if ($usedPoints > 0) {
                    $successMessage .= " Použili ste $usedPoints bodov na zľavu.";
                }
            }

            $this->pdo->commit();

            return ['success' => true, 'message' => $successMessage];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => 'Chyba pri ukladaní rezervácie: ' . $e->getMessage()];
        }
    }
}
