<?php
require_once __DIR__ . '/../db/config.php';
require_once  'Database.php';  // načítame triedu Database
require_once  'Room.php';

use formular\Database;  // predpokladám namespace formular v Database.php

class RoomManager {
    private $conn;

    public function __construct() {
        $db = new \Database();
        $this->conn = $db->getConnection();
    }

    //Získa všetky izby z databázy
    public function getAllRooms() {
        try {
            $query = "SELECT * FROM rooms LIMIT 4";
            $stmt = $this->conn->query($query);

            $rooms = [];

            while ($row = $stmt->fetch()) {
                $rooms[] = new Room($row);
            }

            return $rooms;
        } catch (PDOException $e) {
            die("Chyba pri získavaní izieb: " . $e->getMessage());
        }
    }
}
?>
