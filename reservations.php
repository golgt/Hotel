<?php
include_once "parts/header.php";

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
            <input type="numbre" id="guests"  placeholder="Počet osôb" required>
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
    
    // Skontrolujeme, či je hodnota pre počet hostí platná
    if (!guests || guests < 1) {
        alert("Prosím, zadajte platný počet osôb.");
        return;  // Zastavíme vykonanie ďalšieho kódu
    }

    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const email = document.getElementById('email').value;

    fetch('db/make_reservation.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `room_id=${roomId}&check_in=${checkIn}&check_out=${checkOut}&guests=${guests}&name=${name}&surname=${surname}&email=${email}`
    })
    .then(res => res.json())
    .then(data => {
        const result = document.getElementById('result-message');
        result.textContent = data.message;
        result.style.color = data.success ? 'green' : 'red';
    })
    .catch(err => {
        console.error(err);
        alert('Nastala chyba pri odosielaní formulára.');
    });
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
