<?php
session_start();
require_once("../db/config.php");

try {
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Kontrola POST
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../auth/Login.php?error=Neplatný prístup");
        exit();
    }

    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: ../auth/Login.php?error=Vyplňte všetky polia");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Nastavenie session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        header("Location: ../index.php?success=Prihlásenie úspešné");
        exit();
    } else {
        header("Location: ../auth/Login.php?error=Nesprávny email alebo heslo");
        exit();
    }

} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage(), 3, "../errors.log");
    header("Location: ../auth/Login.php?error=Chyba pri pripojení k databáze");
    exit();
}
?>
