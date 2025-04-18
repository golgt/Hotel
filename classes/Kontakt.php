<?php 
namespace formular;                            //zvolenie namespace pre triedu
use PDOException;
use PDO;
require_once ('../db/config.php');                //konfiguračný súbor s info o db

class Kontakt{
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
            $this->conn = new PDO('mysql:hosts=' . $config['HOST'] . ';dbname=' .$config['DBNAME'] . ';port=' . $config['PORT'], $config['USER_NAME'], $config['PASSWORD'], $options);
        }catch(PDOException $e){
            die("Chyba pripojenia: " . $e->getMessage());
        }
    }
    public function ulozitSpravu($meno, $email, $sprava){               //public metoda prijíma meno,email,sprava kde sa vytvory SQL dotaz na vlozenie do db
        $sql = "INSERT INTO spravy (meno,email,sprava) VALUE ('" . $meno . "', '" . $email . "', '" . $sprava . "')";
        $statement = $this->conn->prepare($sql);
        try{
            $insert = $statement->execute();
            header("Location: http://localhost/sablona/contact.php");
            http_response_code(200);                             //ak je odoslanie uspesne nastavi sa HTTP kod 200(OK) ak nie 404(nenájdené)
            return $insert;
        } catch(\Exception $e){
            return http_response_code(404);
        }
    
    }
    public function __destruct(){                   //deštruktor zatvára pripojenie nastavenim vlastnosti $conn na null 
        $this->conn = null;                     
    }
}
?>