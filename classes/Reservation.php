<?php
class Reservation{
    private PDO $pdo;
    
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function isAvailable(int $roomId, string $checkIn, string $checkOut): bool {            //ak je dostupne tak zapise do databazy rezervaciu
       $stmt = $this->pdo->prepare("
            SELECT * FROM reservations WHERE room_id = ?
            AND(
                (start_date <= ? AND end_date >= ?) OR                                        
                (start_date <= ? AND ? <= end_date) OR
                (? <= start_date AND end_date >= ?)
            )
       ");
       $stmt->execute([
        $roomId, $checkOut, $checkOut,
        $checkIn, $checkIn,
        $checkIn,$checkOut
       ]);
       return $stmt->rowCount() === 0; 
    }
    public function nextAvailableDate(int $roomId): ?string{                                         //vybera datum rezervacie a zistuje ci je dany datum dostupny                   
        $stmt = $this->pdo->prepare("
        SELECT end_date FROM reservations WHERE room_id = ? ORDER BY end_date DESC LIMIT 1
        ");
        $stmt->execute([$roomId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            $nextDate = new DateTime($row['end_date']);
            $nextDate->modify('+1 day');
            return $nextDate->format('Y-m-d');
        }
        return null;
    }
}
?>