<?php 
session_start();
include_once "parts/header.php";
$userLoggedIn = isset($_SESSION['user_id']);

    $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Načítanie izieb
    $stmt = $pdo->prepare("SELECT id, name, capacity, price FROM rooms");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php"?>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>U Ovečky luxus ako nikde inde</h1>
                        <p>Nachádzajú sa tu najlepšie ponuky izieb rovnako aj typy na výlety v blízkom okolí ale aj v zahraničí.</p>
                        <a href="rooms.php" class="primary-btn">Zistiť viac</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <div class="room-booking">
                            <div class="container">
                                <h3>Zarezervujte si hotel</h3>
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

                                <div id="result-message" style="margin-top: 10px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/hero/hero-1NEWer.png"></div>
            <div class="hs-item set-bg" data-setbg="img/hero/hero-2NEWer.png"></div>
            <div class="hs-item set-bg" data-setbg="img/hero/hero-3NEWer.png"></div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>O nás</span>
                            <h2>Hotel<br /> v krásnych Alpách</h2>
                        </div>
                        <p class="f-para">U Ovečky je novovytvorený hotelový rezort ktorý ponúka veľa luxusných služieb a pohodlné ubytovanie. Máme profesionálne 
                            vzškolených zamestnancov ktorý sa postarajú o Vaše pohodlie.
                        </p>
                        <p class="s-para">Takže pokiaľ ide o rezerváciu dokonalého hotela, 
                            dovolenkového prenájmu, rezortu, apartmánu, penziónu alebo domu na strome, máme pre vás všetko.</p>
                        <a href="about-us.php" class="primary-btn about-btn">Zistiť viac</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="img/about/about-1NEWer.jpg" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="img/about/about-2NEW.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Services Section End -->
     <?php
     require_once __DIR__ . "/classes/Service.php";
     require_once __DIR__ . "/classes/ServiceManager.php";

     $serviceManager = new ServiceManager();
    ?>
    
    <section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Čo ešte ponúkame</span>
                    <h2>Objavte Naše Služby</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                // Zavolanie metódy na zobrazenie služieb
                $serviceManager->renderServices();
            ?>
        </div>
    </div>
</section>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <?php
    require_once __DIR__ . "/classes/RoomManager.php";

    try {
        $roomManager = new RoomManager();
        $rooms = $roomManager->getAllRooms();
    } catch (Exception $e) {
        die("Chyba pri načítaní izieb: " . $e->getMessage());
    }
    ?>

    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    <?php foreach ($rooms as $room): ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="hp-room-item set-bg" data-setbg="<?php echo htmlspecialchars($room->image); ?>">
                                <div class="hr-text">
                                    <h3><?php echo htmlspecialchars($room->name); ?></h3>
                                    <h2><?php echo $room->price; ?>€<span>/noc</span></h2>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="r-o">Veľkosť:</td>
                                                <td><?php echo htmlspecialchars($room->size); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Kapacita:</td>
                                                <td><?php echo htmlspecialchars($room->capacity); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Postel:</td>
                                                <td><?php echo htmlspecialchars($room->bed); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="r-o">Služby:</td>
                                                <td><?php echo htmlspecialchars($room->services); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <a href="room-details.php?id=<?php echo $room->id; ?>" class="primary-btn">Detaily</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Hodnotenia</span>
                        <h2>Čo hovoria zákazníci?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">                                     <!--načítavanie sprav z databazy-->
                            <?php 
                                require_once 'db/config.php';
                                $stmt = $pdo->prepare("SELECT meno, sprava FROM spravy");
                                $stmt->execute();
                                $spravy = $stmt->fetchAll();

                                foreach ($spravy as $sprava){
                                    echo '<div class="ts-item">';
                                    echo '<p>' . htmlspecialchars($sprava['sprava']) . '</p>';
                                    echo '<div class = "ti-author">';
                                    echo '<h5>' . htmlspecialchars($sprava['meno']) . '</h5>';                                   
                                    echo '</div>';
                                    echo '<img src="img/testimonial-logo.png" alt="">';
                                    echo '</div>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <?php include_once "parts/footer.php"?>

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

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