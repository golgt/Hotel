<?php

require_once __DIR__ . "/../db/config.php";

/**
 * Trieda Database pre správu pripojenia k databáze
 */
class Database{

    private PDO $conn;

    public function __construct(){
        $this->connect();
    }

    private function connect(){                        
        $config = DATABASE;

        // Nastavenie PDO atribútov
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Automatické vyhadzovanie výnimiek pri chybách
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  // Predvolený formát výsledkov ako asociatívne pole
        );

        try{
            // Vytvorenie PDO pripojenia s nastavenými parametrami
            $this->conn = new PDO('mysql:host=' . $config['HOST'] . ';dbname=' .$config['DBNAME'] . ';port=' . $config['PORT'], 
                                 $config['USER_NAME'], 
                                 $config['PASSWORD'], 
                                 $options);
        }catch(PDOException $e){
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }
    public function getConnection(): PDO{
        return $this->conn;
    }
}
?>
