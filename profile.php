<?php
session_start();
require_once 'db/config.php';

// Debug výpis
echo "Session ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "Nie je nastavené") . "<br>";

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

    // Získanie údajov o používateľovi
    $stmt = $pdo->prepare("SELECT name, lastname, email, loyalty_points FROM users WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        // Ak používateľ neexistuje, zrušíme session a presmerujeme na prihlásenie
        session_unset();
        session_destroy();
        header("Location: login.php?error=Používateľ neexistuje. Prihláste sa znovu.");
        exit();
    }
} catch (PDOException $e) {
    echo "Chyba databázy: " . $e->getMessage();
    exit();
}

// Zahrnutie hlavičky, navigácie a päty
include_once "parts/header.php";
include_once "parts/navbar.php";
?>

<div class="container profile-container">
    <h2 class="text-center">Vitaj, <?= htmlspecialchars($user['name'] . ' ' . $user['lastname']) ?></h2>
    <div class="profile-details">
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Vernostné body:</strong> <?= htmlspecialchars($user['loyalty_points']) ?> bodov</p>
    </div>
    <div class="profile-actions text-center">
        <a href="edit-profile.php" class="btn btn-primary">Upraviť profil</a>
        <a href="auth/logout.php" class="btn btn-danger">Odhlásiť</a>
    </div>
</div>
<br>
<?php 
// Zahrnutie päty
include_once "parts/footer.php"; 
?>
