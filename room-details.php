<?php include_once "parts/header.php"; ?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php"; ?>

    <?php 
    require_once "classes/Room.php";

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  //pripojenie k databaze
        ]);
    } catch (PDOException $e) {
        die("Pripojenie s databázou zlyhalo" . $e->getMessage());
    }
    if(!isset($_GET['id'])) {
        die("Neplatne ID izby");
    }

    $id = (int)$_GET['id'];

    // Načítanie údajov o izbe
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->execute([$id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$row){
        die("Izba nebola nájdená.");
    }

    $room = new Room($row);

    // Načítanie recenzií pre túto izbu
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE room_id = ? ORDER BY created_at DESC");
    $stmt->execute([$id]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php $room->renderDetail(); ?>
                </div>

                <!-- Pravý panel na rezerváciu -->
                <div class="col-lg-4">
                    <?php 
                    $sidebarRoom = $room;
                    include "parts/room-sidebar.php"; 
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section class="room-details-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="rd-reviews">
                        <h4>Recenzie</h4>
                        <?php if (count($reviews) > 0): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item">
                                    <div class="ri-pic">
                                        <img src="img/room/avatar/avatar-1.jpg" alt="">
                                    </div>
                                    <div class="ri-text">
                                        <span><?= htmlspecialchars($review['created_at']); ?></span>
                                        <div class="rating">
                                            <?php 
                                            // Zobrazenie hodnotenia ako hviezdičky
                                            for ($i = 0; $i < 5; $i++) {
                                                if ($i < $review['rating']) {
                                                    echo '<i class="icon_star"></i>';
                                                } else {
                                                    echo '<i class="icon_star-half_alt"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                        <h5><?= htmlspecialchars($review['name']); ?></h5>
                                        <p><?= htmlspecialchars($review['comment']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Žiadne recenzie zatiaľ neboli pridané.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="review-add">
                        <h4>Pridať recenziu</h4>
                        <form action="db/spracovanieReviews.php" method="post" class="contact-form">
                            <input type="hidden" name="room_id" value="<?= $room->id ?>"> <!-- Pridáme ID izby -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="name" placeholder="Vaše Meno" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" name="email" placeholder="Váš Email" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <h5>Vaše hodnotenie:</h5>
                                    <select name="rating" required>
                                        <option value="5">★★★★★</option>
                                        <option value="4">★★★★☆</option>
                                        <option value="3">★★★☆☆</option>
                                        <option value="2">★★☆☆☆</option>
                                        <option value="1">★☆☆☆☆</option>
                                    </select>
                                </div>
                                <textarea name="comment" placeholder="Vaša recenzia" required></textarea>
                                <button type="submit">Odoslať</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once "parts/footer.php"; ?>

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
</body>

</html>
