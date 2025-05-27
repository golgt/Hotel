<?php
session_start();
require_once 'db/config.php';
require_once "classes/Database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Musíte sa prihlásiť");
    exit();
}

$db = new Database();
$pdo = $db->getConnection();

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

$email = $user['email']; // e-mail prihláseného používateľa

$stmt = $pdo->prepare("
    SELECT r.start_date, r.end_date, r.guests, r.total_price, r.discount_value, ro.name AS room_name
    FROM reservations r
    JOIN rooms ro ON r.room_id = ro.id
    WHERE r.email = :email
    ORDER BY r.start_date DESC
");
$stmt->execute(['email' => $email]);
$rezervacie = $stmt->fetchAll();

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
    <h3>Vaša história rezervácií</h3>
    <br>
<?php if (count($rezervacie) > 0): ?>
    <ul>
    <?php foreach ($rezervacie as $rez): ?>
        <li>
            <strong>Izba:</strong> <?= htmlspecialchars($rez['room_name']) ?><br>
            <strong>Od:</strong> <?= date('d.m.Y', strtotime($rez['start_date'])) ?> 
            <strong>Do:</strong> <?= date('d.m.Y', strtotime($rez['end_date'])) ?><br>
            <strong>Hostí:</strong> <?= (int)$rez['guests'] ?><br>
            <strong>Cena:</strong> <?= number_format($rez['total_price'], 2) ?> €
            <strong>Zľava:</strong> <?= number_format($rez['discount_value'], 2) ?> €
        </li>
        <hr>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Nemáte žiadne rezervácie.</p>
<?php endif; ?>
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
