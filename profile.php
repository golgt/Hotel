<?php 
session_start();
require_once 'db/config.php';

// Kontrola prihlásenia
if(!isset($_SESSION['user_id'])){
    header("Location: login.php?error=Musíte sa prihlásiť");
    exit();
}

try{
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
        echo "Používateľ neexistuje";
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
