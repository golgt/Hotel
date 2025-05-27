<?php
session_start();

require_once "../db/config.php";
require_once "../classes/Database.php";
require_once "../classes/User.php";

// Kontrola či bol formulár odoslaný metódou POST
if ($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: login.php?error=Neplatný prístup");
    exit();
}

// Získanie a očistenie vstupných dát z formulára
$email = trim($_POST["email"] ?? '');
$password = $_POST["password"] ?? '';

// Validácia či boli vyplnené všetky polia
if(empty($email) || empty($password)){
    header("Location: ../login.php?error=Vyplňte všetky polia");
    exit();
}

try{
    // Inicializácia databázového pripojenia
    $db = new Database();
    $pdo = $db->getConnection();

    // Vytvorenie inštancie User modelu a kontrola prihlasovacích údajov
    $userModel = new User($pdo);
    $user = $userModel->getUserByEmail($email);

    // Overenie hesla a prihlásenie používateľa
    if($user && password_verify($password, $user["password"])){
        // Nastavenie session premenných pre prihláseného používateľa
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: ../profile.php?success=Prihlásenie úspešné");
        exit();
    } else {
        header("Location: ../login.php?error=Nesprávny email alebo heslo");
        exit();
    }
} catch (PDOException $e) {
    // Logovanie chyby do súboru
    error_log("Login error: " . $e->getMessage(), 3, "../errors.log");
    header("Location: ../login.php?error=Chyba pri pripojení k databáze");
    exit();
}
?>
