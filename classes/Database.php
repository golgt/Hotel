<?php

require_once("../db/config.php");

/**
 * Trieda Database pre správu pripojenia k databáze
 */
class Database{

    private PDO $conn;

    /**
     * Konštruktor triedy - automaticky vytvorí pripojenie k databáze
     */
    public function __construct(){
        $this->connect();
    }

    /**
     * Privátna metóda pre vytvorenie pripojenia k databáze
     * Nastavuje PDO atribúty pre lepšiu prácu s chybami a formátom výsledkov
     */
    private function connect(){                        
        $config = DATABASE;

        // Nastavenie PDO atribútov
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Automatické vyhadzovanie výnimiek pri chybách
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC  // Predvolený formát výsledkov ako asociatívne pole
        );

        try{
            // Vytvorenie PDO pripojenia s nastavenými parametrami
            $this->conn = new PDO('mysql:hosts=' . $config['HOST'] . ';dbname=' .$config['DBNAME'] . ';port=' . $config['PORT'], 
                                 $config['USER_NAME'], 
                                 $config['PASSWORD'], 
                                 $options);
        }catch(PDOException $e){
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }

    /**
     * Metóda pre získanie aktívneho pripojenia k databáze
     * @return PDO Aktívne pripojenie k databáze
     */
    public function getConnection(): PDO{
        return $this->conn;
    }
}
?>
