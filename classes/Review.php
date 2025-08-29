<?php 
namespace reviews;

use PDOException;


require_once __DIR__ . '/../db/config.php';
require_once 'Database.php';

session_start();

class Review {
    private $conn;

    public function __construct() {
        $db = new \Database();
        $this->conn = $db->getConnection();
    }

    public function ulozitSpravu($roomId, $name, $email, $rating, $comment) {
        $sql = "INSERT INTO reviews (room_id, user_id, name, email, rating, comment) 
                VALUES (:room_id, :user_id, :name, :email, :rating, :comment)";
        $statement = $this->conn->prepare($sql);

        try {
            $userId = $_SESSION['user_id'] ?? null;

            $statement->execute([
                ':room_id' => $roomId,
                ':user_id' => $userId,
                ':name' => $name,
                ':email' => $email,
                ':rating' => $rating,
                ':comment' => $comment
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
?>
