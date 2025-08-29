<?php
// Spustenie session pre sledovanie prihláseného používateľa
session_start();

// Načítanie potrebných súborov
require_once '../db/config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';

// Kontrola či je používateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Musíte sa prihlásiť");
    exit();
}

try {
    // Inicializácia databázového pripojenia
    $db = new Database();
    $pdo = $db->getConnection();

    // Vytvorenie inštancie User modelu a získanie dát používateľa
    $userModel = new User($pdo);
    $user = $userModel->getUserById($_SESSION['user_id']);

    // Kontrola či používateľ existuje
    if (!$user) {
        echo "Používateľ neexistuje";
        exit();
    }

    // Spracovanie POST požiadavky na aktualizáciu profilu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Získanie a očistenie vstupných dát
        $new_name = trim($_POST['name']);
        $new_lastname = trim($_POST['lastname']);
        $new_email = trim($_POST['email']);
        $new_password = $_POST['password'];

        // Validácia vstupných dát
        if (empty($new_name) || empty($new_lastname) || empty($new_email)) {
            $error_message = "Všetky polia sú povinné.";
        } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Neplatný email.";
        } elseif (!empty($new_password) && strlen($new_password) < 6) {
            $error_message = "Heslo musí mať aspoň 6 znakov.";
        } elseif (!empty($new_password) && !preg_match("/[A-Z]/", $new_password)) {
            $error_message = "Heslo musí obsahovať aspoň jedno veľké písmeno.";
        } elseif (!empty($new_password) && !preg_match("/[0-9]/", $new_password)) {
            $error_message = "Heslo musí obsahovať aspoň jedno číslo.";
        } elseif (!empty($new_password) && !preg_match("/[a-z]/", $new_password)) {
            $error_message = "Heslo musí obsahovať aspoň jedno malé písmeno.";
        }

        // Ak validácia prešla úspešne, aktualizuj údaje používateľa
        if (!isset($error_message)) {
            $userModel->updateUser($_SESSION['user_id'], $new_name, $new_lastname, $new_email, $new_password);
            header("Location: ../profile.php?success=Údaje boli úspešne upravené.");
            exit();
        }
    }
} catch (PDOException $e) {
    // Spracovanie chyby pri práci s databázou
    echo "Chyba databázy: " . $e->getMessage();
    exit();
}
?>
