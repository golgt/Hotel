<?php include_once "parts/header.php"; 
    include_once "classes/Database.php";
    session_start();
?>

<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php"; ?>

    <?php
    require_once "classes/Room.php";

    // DB pripojenie
    $db = new Database();
    $pdo = $db->getConnection();

    $stmt = $pdo->query("SELECT * FROM rooms");                      //načítavanie z databázy

    $rooms = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rooms[] = new Room($row);
    }
    ?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Naše Izby</h2>
                        <div class="bt-option">
                            <a href="index.php">Domov</a>
                            <span>Izby</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad">
        <div class="container">
            <div class="row">
                <?php foreach ($rooms as $room) {
                    $room->render();
                } ?>
            </div>
        </div>
    </section>
    <!-- Rooms Section End -->

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
