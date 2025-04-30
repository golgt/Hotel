<?php 
session_start();
header('Content-type: text/html; charset=utf-8');

try {
    // Pripojenie k databáze
    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Kontrola, či bol formulár odoslaný metódou POST
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        header("Location: ../registration.php?error=Neplatný prístup");
        exit();
    }

    // Získanie údajov z formulára
    $name = trim($_POST["name"] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $gender = $_POST['gendewr'] ?? '';
    

    // Validácia údajov
    if (empty($name) || empty($lastname) || empty($email) || empty($password)) {
        header("Location: ../registration.php?error=Vyplňte všetky polia");
        exit();
    }

    // Validácia emailu
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../registration.php?error=Neplatný email");
        exit();
    }

    // Kontrola, či email už existuje
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        header("Location: ../registration.php?error=Email už existuje");
        exit();
    }

    // Heslo musí mať aspoň 6 znakov
    if (strlen($password) < 6) {
        header("Location: ../registration.php?error=Heslo musí mať aspoň 6 znakov");
        exit();
    }

    // Hashovanie hesla
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Vloženie nového používateľa do databázy
    $stmt = $pdo->prepare("INSERT INTO users (name, lastname, email, password, loyalty_points, gender) VALUES (?, ?, ?, ?, 10, ?)");
    $stmt->execute([$name, $lastname, $email, $password_hash,$gender]);

    // Získanie ID novovytvoreného používateľa
    $user_id = $pdo->lastInsertId();

    // Prihlásenie používateľa
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    // Presmerovanie na úspešnú stránku
    header("Location: ../index.php?success=Registrácia úspešná! Ste prihlásený.");
    exit();

} catch (PDOException $e) {
    // Log the error to a file
    echo "Chyba pri pripojení: " . $e->getMessage();
    header("Location: ../registration.php?error=Chyba pri registrácií. Skúste to znova neskôr.");
    exit();
}
?>
