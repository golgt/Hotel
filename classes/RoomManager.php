<?php 
// Načítanie potrebných súborov
require_once __DIR__ . "/../db/config.php";  
require_once __DIR__ . "/Room.php";          

class RoomManager {
    private $conn;  

    public function __construct() {
        $config = DATABASE;  

        try {
            $dsn = "mysql:host=" . $config['HOST'] . ";dbname=" . $config['DBNAME'] . ";port=" . $config['PORT'];
            
            // Inicializácia PDO pripojenia s prihlasovacími údajmi
            $this->conn = new PDO($dsn, $config['USER_NAME'], $config['PASSWORD']);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Nastavenie kódovania znakov na UTF-8
            $this->conn->exec("SET NAMES utf8");
        } catch (PDOException $e) {
            die("Chyba pripojenia k databáze: " . $e->getMessage());
        }
    }

    /**
     * Získa všetky izby z databázy
     * @return array Pole objektov Room
     */
    public function getAllRooms() {
        try {
            // SQL dotaz na získanie všetkých izieb (obmedzené na 4 pre zobrazenie na hlavnej stránke)
            $query = "SELECT * FROM rooms LIMIT 4";
            
            // Vykonanie dotazu a získanie objektu statement
            $stmt = $this->conn->query($query);
            
            // Inicializácia prázdneho poľa pre izby
            $rooms = [];
            
            // Prechádzanie výsledkov a vytváranie objektov Room
            while ($row = $stmt->fetch()) {
                $rooms[] = new Room($row);  // Vytvorenie nového objektu Room z dát riadka
            }
            
            return $rooms;
        } catch (PDOException $e) {
            die("Chyba pri získavaní izieb: " . $e->getMessage());
        }
    }

    /**
     * Destruktor - Zatvorí pripojenie k databáze pri zničení objektu
     */
    public function __destruct() {
        $this->conn = null;  // Zatvorenie PDO pripojenia
    }
}
?>