<?php 
class LoyaltyManager{
    private $conn;

    public function __construct($pdo){
        $this->conn = $pdo;
    }
    //Získa aktuálny počet bodov od používatela
    public function getPoints($userId){
        $stmt = $this->conn->prepare("SELECT loyalty_points FROM users WHERE ID = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
    //uplatní vernostné body na zníženie ceny
    public function applyPoints($userId, $price){
        $points = $this->getPoints($userId);

        $discount = min($points * 0.1, $price);   //1 bod = 10 centov zlava
        $newPrice = $price - $discount;

        $pointsToRemove = floor($discount / 0.1);

        //odpočítanie bodov
        if($pointsToRemove > 0){
            $stmt = $this->conn->prepare("UPDATE users SET loyalty_points = loyalty_points - ? WHERE id = ?");
            $stmt->execute([$pointsToRemove, $userId]);
        }
        return $newPrice;
    }
    //pridá body za novú rezernváciu
    public function addPoints($userId, $price){
        $points = floor($price / 10); //1 bod za každých 10€
        $stmt = $this->conn->prepare("UPDATE users SET loyalty_points = loyalty_points + ? WHERE id = ?");
        $stmt->execute([$points, $userId]);
    }
}
?>