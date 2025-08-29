<?php 
namespace formular;

use PDOException;

require_once __DIR__ . '/../db/config.php';
require_once 'Database.php';    // správna cesta k Database.php

class Kontakt {
    private $conn;

    public function __construct() {
        // Vytvoríme inštanciu Database a získame PDO pripojenie
        $db = new \Database();
        $this->conn = $db->getConnection();
    }

    public function ulozitSpravu($meno, $email, $sprava) {
        $sql = "INSERT INTO spravy (meno, email, sprava) VALUES (:meno, :email, :sprava)";
        $statement = $this->conn->prepare($sql);

        try {
            $insert = $statement->execute([
                ':meno' => $meno,
                ':email' => $email,
                ':sprava' => $sprava
            ]);
            header("Location: http://localhost/sablona/contact.php");
            http_response_code(200);
            return $insert;
        } catch (\Exception $e) {
            return http_response_code(404);
        }
    }
}
?>
