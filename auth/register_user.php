<?php 
// Spustenie session pre sledovanie prihláseného používateľa
session_start();
// Nastavenie kódovania pre správne zobrazenie diakritiky
header('Content-type: text/html; charset=utf-8');

// Načítanie potrebných súborov
require_once "../db/config.php";
require_once "../classes/Database.php";
require_once "../classes/User.php";

// Kontrola, či bol formulár odoslaný metódou POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../registration.php?error=Neplatný prístup");
    exit();
}

// Získanie a očistenie vstupných dát z formulára
$name = trim($_POST["name"] ?? '');
$lastname = trim($_POST["lastname"] ?? '');
$email = trim($_POST["email"] ?? '');
$password = $_POST["password"] ?? '';
$gender = $_POST["gender"] ?? '';

// Validácia povinných polí
if (empty($name) || empty($lastname) || empty($email) || empty($password)) {
    header("Location: ../registration.php?error=Vyplňte všetky polia");
    exit();
}

// Validácia formátu emailu
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../registration.php?error=Neplatný email");
    exit();
}

// Validácia dĺžky hesla
if (strlen($password) < 6) {
    header("Location: ../registration.php?error=Heslo musí mať aspoň 6 znakov");
    exit();
}

try {
    // Inicializácia databázového pripojenia
    $db = new Database();
    $pdo = $db->getConnection();
    $userModel = new User($pdo);

    // Kontrola, či email už nie je registrovaný
    if ($userModel->getUserByEmail($email)) {
        header("Location: ../registration.php?error=Email už existuje");
        exit();
    }

    // Registrácia nového používateľa
    $userId = $userModel->registerUser($name, $lastname, $email, $password, $gender);

    // Nastavenie session premenných pre prihláseného používateľa
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;

    // Presmerovanie na úvodnú stránku po úspešnej registrácii
    header("Location: ../index.php?success=Registrácia úspešná! Ste prihlásený.");
    exit();

} catch (PDOException $e) {
    // Logovanie chyby do súboru
    error_log("Registration error: " . $e->getMessage(), 3, "../errors.log");
    header("Location: ../registration.php?error=Chyba pri registrácií. Skúste to znova neskôr.");
    exit();
}
?>
