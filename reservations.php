<?php
session_start();
include_once "parts/header.php";
include_once "classes/Database.php";
$userLoggedIn = isset($_SESSION['user_id']);

$db = new Database();
$pdo = $db->getConnection();
// Načítanie izieb
$stmt = $pdo->prepare("SELECT id, name, capacity, price FROM rooms");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
<div id="preloder"><div class="loader"></div></div>
<?php include_once "parts/navbar.php"; ?>

<div class="room-booking">
    <div class="container">
    <h3>Vyplňte svoju rezerváciu</h3>
    <form id="reservation-form">
        
        <!-- Výber izby -->
        <div class="check-date">
            <label for="room-select">Izba:</label>
            <select id="room-select" name="room_id" required>
                <option value="">-- Vyber izbu --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>" data-price="<?= $room['price'] ?>" data-capacity="<?= intval(preg_replace('/\D/', '', $room['capacity'])) ?>">
                        <?= htmlspecialchars($room['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <br>
        <!-- Dátumy -->
        <div class="check-date">
            <label for="check-in">Check In:</label>
            <input type="date" id="check-in" required>
            
        </div>
        <div class="check-date">
            <label for="check-out">Check Out:</label>
            <input type="date" id="check-out"  required>
            
        </div>

        <!-- Počet osôb -->
        <div class="check-date">
            <label for="guests">Počet osôb:</label>
            <input type="number" id="guests"  placeholder="Počet osôb" required>
        </div>
        <!-- Osobné údaje -->
        <div class="check-date">
            <label for="name">Meno:</label>
            <input type="text" id="name" placeholder="Meno" required>
        </div>

        <div class="check-date">
            <label for="surname">Priezvisko:</label>
            <input type="text" id="surname" placeholder="Priezvisko" required>
        </div>

        <div class="check-date">
            <label for="email">Email:</label>
            <input type="email" id="email" placeholder="Email" required>
        </div>
        <div class="check-date">
        <label for="final-price">Celková cena:</label>
            <p id="final-price">0.00 €</p>
        </div>

        <button type="button" id="proceed-to-payment">Pokračovať k platbe</button>
    </form>

    <div id="result-message" style="margin-top: 10px;"></div>
  </div>
</div>
<?php
$userPoints = 0;
if ($userLoggedIn) {
    $stmt = $pdo->prepare("SELECT loyalty_points FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userPoints = $result ? $result['loyalty_points'] : 0;
}
include_once "modal/modal.php";
?>

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
<script src="js/reservation.js"></script>
</body>
</html>