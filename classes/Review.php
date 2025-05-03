<?php 
namespace reviews;                            //zvolenie namespace pre triedu
use PDOException;
use PDO;
require_once ('../db/config.php');                //konfiguračný súbor s info o db
session_start();
class Review{
    private $conn;                  

    public function __construct(){
        $this->connect();
    }
    private function connect(){                        //private mnetoda na spojenie s db            
        $config = DATABASE;

        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try{
            $this->conn = new PDO('mysql:hosts=' . $config['HOST'] . ';dbname=' .$config['DBNAME'] . ';port=' . $config['PORT'],
  $config['USER_NAME'], $config['PASSWORD'], $options);
        }catch(PDOException $e){
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }
    public function ulozitSpravu($roomId, $name, $email, $rating, $comment){
        $sql = "INSERT INTO reviews (room_id, user_id, name, email, rating, comment) 
        VALUES (:room_id, :user_id, :name, :email, :rating, :comment)";
    
        $statement = $this->conn->prepare($sql);
    
        try {
            // Získame user_id priamo z $_SESSION
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
            // Ak nie je prihlásený používateľ, ulož recenziu bez user_id
            if ($userId === null) {
                $statement->execute([
                    ':room_id' => $roomId,
                    ':user_id' => null, // Ak používateľ nie je prihlásený, môžeš nastaviť null
                    ':name' => $name,
                    ':email' => $email,
                    ':rating' => $rating,
                    ':comment' => $comment
                ]);
            } else {
                $statement->execute([
                    ':room_id' => $roomId,
                    ':user_id' => $userId, // Použijeme prihláseného používateľa
                    ':name' => $name,
                    ':email' => $email,
                    ':rating' => $rating,
                    ':comment' => $comment
                ]);
            }
    
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function __destruct(){                   //deštruktor zatvára pripojenie nastavenim vlastnosti $conn na null 
        $this->conn = null;                     
    }
}
?>