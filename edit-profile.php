<?php
session_start();
require_once 'db/config.php';

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
} catch (PDOException $e) {
    echo "Chyba databázy: " . $e->getMessage();
    exit();
}

include_once "parts/header.php";
include_once "parts/navbar.php";
?>

<div class="container">
    <h2 class="text-center">Upraviť profil</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <form action="profile/process-edit-profile.php" method="POST">
        <div class="form-group">
            <label for="name">Meno:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="lastname">Priezvisko:</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Nové heslo (ak chcete zmeniť):</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Zadajte nové heslo (ak chcete zmeniť)">
        </div>
        <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
    </form>
</div>

<?php include_once "parts/footer.php"; ?>
 <!-- Search model -->
 <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>