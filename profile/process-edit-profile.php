<?php
session_start();
require_once '../db/config.php';

// Ak nie je používateľ prihlásený, presmeruj na prihlásenie
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Musíte sa prihlásiť");
    exit();
}

try {
    // Pripojenie k databáze
    $pdo = new PDO("mysql:host=" . DATABASE['HOST'] . ";dbname=" . DATABASE['DBNAME'] . ";port=" . DATABASE['PORT'], DATABASE['USER_NAME'], DATABASE['PASSWORD'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Získanie aktuálnych údajov používateľa
    $stmt = $pdo->prepare("SELECT name, lastname, email, loyalty_points FROM users WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "Používateľ neexistuje";
        exit();
    }

    // Spracovanie formulára (update údajov)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_name = trim($_POST['name']);
        $new_lastname = trim($_POST['lastname']);
        $new_email = trim($_POST['email']);
        $new_password = $_POST['password'];

        // Validácia údajov
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
        } else {
            // Ak je zadané nové heslo, aktualizujeme aj heslo
            if (!empty($new_password)) {
                $new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ?, password = ? WHERE id = ?");
                $stmt->execute([$new_name, $new_lastname, $new_email, $new_password, $_SESSION['user_id']]);
            } else {
                // Aktualizácia bez zmeny hesla
                $stmt = $pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ? WHERE id = ?");
                $stmt->execute([$new_name, $new_lastname, $new_email, $_SESSION['user_id']]);
            }

            // Po úspešnej úprave presmeruj na profil
            header("Location: ../profile.php?success=Údaje boli úspešne upravené.");
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Chyba databázy: " . $e->getMessage();
    exit();
}
?>
