<?php
session_start();
include_once "parts/header.php";
$userLoggedIn = isset($_SESSION['user_id']);

$pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// Načítanie izieb
$stmt = $pdo->prepare("SELECT id, name, capacity FROM rooms");
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
                    <option value="<?= $room['id'] ?>" data-capacity="<?= intval(preg_replace('/\D/', '', $room['capacity'])) ?>">
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

        <button type="submit">Odoslať</button>
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
?>
<!-- Modálne okno pre platbu -->
<div id="payment-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
    <div id="payment-modal-content" style="background-color: white; padding: 20px; border-radius: 8px; width: 400px;">
        <h4 id="payment-modal-title">Platba</h4>

        <!-- Verostné body a formulár -->
        <div class="loyalty-points" style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 15px;">
            <h5>Vernostné body</h5>
            <p>Aktuálny stav: <strong><?= $userPoints ?> bodov</strong> (hodnota: <?= number_format($userPoints * 0.1, 2) ?> €)</p>

            <?php if ($userPoints > 0): ?>
            <div class="points-options">
                <div class="points-option" style="margin-bottom: 10px;">
                    <input type="checkbox" id="use-all-points">
                    <label for="use-all-points">Použiť body na zľavu (max. 25% z celkovej sumy)</label>
                </div>
                <div class="points-slider-container" style="display: none; margin-top: 10px;">
                    <input type="range" id="points-slider" min="0" max="<?= $userPoints ?>" value="0" style="width: 100%;">
                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                        <span>0 bodov</span>
                        <span id="points-value">0 bodov</span>
                        <span><?= $userPoints ?> bodov</span>
                    </div>
                    <div style="margin-top: 10px;">
                        <p>Zľava: <span id="discount-value">0.00</span> €</p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p>Nemáte dostatok bodov na zľavu.</p>
            <?php endif; ?>
        </div>

        <!-- Možnosti platby -->
        <div class="payment-options" style="margin-top: 20px;">
            <div class="payment-option" style="margin-bottom: 15px;">
                <input type="radio" id="reception-payment" name="payment" value="reception" checked>
                <label for="reception-payment">Platba pri recepcii</label>
            </div>
            <div class="payment-option" style="margin-bottom: 15px;">
                <input type="radio" id="card-payment" name="payment" value="card">
                <label for="card-payment">Platba kartou online</label>
            </div>
        </div>

        <!-- Tlačidlo pre potvrdenie platby pri recepcii -->
        <div id="reception-payment-confirm" style="margin-top: 20px;">
            <button action="submit" type="submit" id="confirm-reception-payment" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%;">Potvrdiť rezerváciu</button>
        </div>

        <!-- Formulár pre platbu kartou -->
        <div id="card-payment-form" style="display: none;">
            <h4>Platba kartou</h4>
            <div class="card-form" style="margin-top: 15px;">
                <div style="margin-bottom: 15px;">
                    <label for="card-number" style="display: block; margin-bottom: 5px;">Číslo karty:</label>
                    <input type="text" id="card-number" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="expiry-date" style="display: block; margin-bottom: 5px;">Dátum expirácie:</label>
                    <input type="month" id="expiry-date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="cvv" style="display: block; margin-bottom: 5px;">CVV:</label>
                    <input type="text" id="cvv" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                </div>

                <button type="button" id="payment-modal" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; ">Zaplatiť</button>
                <div id="thank-you-message" style="display: none;"></div>
            </div>
        </div>

        <!-- Poďakovanie po platbe -->
        <div id="thank-you-message" style="display: none;">
            <h3>Ďakujeme za Vašu objednávku!</h3>
            <p>Vaša objednávka bola úspešne spracovaná.</p>
            <button id="finish-order-btn" style="background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px;">Dokončiť</button>
        </div>

        <!-- Tlačidlo na zatvorenie okna -->
        <button id="close-modal" style="margin-top: 20px; background-color: #f44336; color: white; padding: 10px; border: none; border-radius: 5px;">Zatvoriť</button>
    </div>
</div>
<!-- Dynamické generovanie počtu osôb -->
<script>
document.getElementById('room-select').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const capacity = parseInt(selected.getAttribute('data-capacity'));
    const guestSelect = document.getElementById('guests');

    guestSelect.innerHTML = '';

    if (!isNaN(capacity)) {
        for (let i = 1; i <= capacity; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = `${i} ${i === 1 ? 'osoba' : 'osoby'}`;
            guestSelect.appendChild(option);
        }
    } else {
        const option = document.createElement('option');
        option.textContent = 'Kapacita nie je dostupná';
        guestSelect.appendChild(option);
    }
});

// Odoslanie formulára

document.getElementById('reservation-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const roomId = document.getElementById('room-select').value;
    const checkIn = document.getElementById('check-in').value;
    const checkOut = document.getElementById('check-out').value;
    const guests = document.getElementById('guests').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const email = document.getElementById('email').value;

    if (!guests || guests < 1) {
        alert("Prosím, zadajte platný počet osôb.");
        return;
    }

    fetch('db/make_reservation.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}&guests=${guests}&name=${name}&surname=${surname}&email=${email}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Otvor modal pre platbu
            document.getElementById('payment-modal').style.display = 'flex';
            alert(data.message);
            document.getElementById('reservation-form').reset();
            document.getElementById('guests').innerHTML = '';
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Nastala chyba pri odosielaní formulára.');
    });
});
</script>

<script>
document.getElementById('reservation-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    const response = await fetch('reservations.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.json();

    if (result.success) {
        // Zobraziť modal
        document.getElementById('payment-modal').style.display = 'flex';

        // (Voliteľne) aktualizovať hodnoty
        alert(result.message); // Alebo zobraz v modale

    } else {
        alert(result.message);
    }
});
</script>
<script>
const useAllPointsCheckbox = document.getElementById('use-all-points');
const pointsSlider = document.getElementById('points-slider');
const pointsSliderContainer = document.querySelector('.points-slider-container');
const pointsValueLabel = document.getElementById('points-value');
const discountValue = document.getElementById('discount-value');

const maxDiscountPercent = 25;

useAllPointsCheckbox?.addEventListener('change', () => {
    pointsSliderContainer.style.display = useAllPointsCheckbox.checked ? 'block' : 'none';
});

pointsSlider?.addEventListener('input', () => {
    const points = parseInt(pointsSlider.value, 10);
    const discount = (points * 0.1).toFixed(2); // Každý bod = 0.1 €
    pointsValueLabel.textContent = `${points} bodov`;
    discountValue.textContent = `${discount} €`;
});
</script>
<script>
document.querySelectorAll('input[name="payment"]').forEach(input => {
    input.addEventListener('change', () => {
        const cardForm = document.getElementById('card-payment-form');
        const receptionConfirm = document.getElementById('reception-payment-confirm');

        if (input.value === 'card') {
            cardForm.style.display = 'block';
            receptionConfirm.style.display = 'none';
        } else {
            cardForm.style.display = 'none';
            receptionConfirm.style.display = 'block';
        }
    });
});
</script>
<script>
document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('payment-modal').style.display = 'none';
});
</script>


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