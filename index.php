<?php include_once "parts/header.php"?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php"?>

    <!-- Hero Section Begin -->
    <?php include_once "index/hero_section.php"?>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <?php include_once "index/about_us.php" ?>
    <!-- About Us Section End -->

    <!-- Services Section End -->
   <?php include_once "index/services.php"?>
    <!-- Services Section End -->

    <!-- Home Room Section Begin -->
    <?php include_once "index/home_room_section.php"?>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <?php include_once "index/testimonial.php"?>
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
</body>

</html>