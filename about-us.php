<?php include_once "parts/header.php";
    session_start();
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

   <?php include_once "parts/navbar.php";?>

    <!-- Breadcrumb Section Begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>O nás</h2>
                        <div class="bt-option">
                            <a href="./index.php">Domov</a>
                            <span>O nás</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section End -->

    <!-- About Us Page Section Begin -->
    <section class="aboutus-page-section spad">
        <div class="container">
            <div class="about-page-text">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ap-title">
                            <h2>Vitajte U Ovesky.</h2>
                            <p>Postavený v roku 1912 počas obdobia Belle Epoque, tento hotel sa nachádza
                                v najkrajšej časti Francúzkych Álp. Ponúkame klasicky ale aj moderne vybavené apartmány.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <ul class="ap-services">
                            <li><i class="icon_check"></i> Vernostný program na zisk bodov.</li>
                            <li><i class="icon_check"></i> Kompletné Denné Raňajky</li>
                            <li><i class="icon_check"></i> Luxusné služby v cene</li>
                            <li><i class="icon_check"></i> Free Wifi.</li>
                            <li><i class="icon_check"></i> Možnosť uplatniť body na zľavu</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="about-page-services">
                <div class="row">
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="img/about/about-p1.jpg">
                            <div class="api-text">
                                <h3>Reštaurácie</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="img/about/about-p2.jpg">
                            <div class="api-text">
                                <h3>Cestovanie & Camping</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="ap-service-item set-bg" data-setbg="img/about/about-p3.jpg">
                            <div class="api-text">
                                <h3>Event & Party</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Page Section End -->

    <!-- Video Section Begin -->
    <section class="video-section set-bg" data-setbg="img/video-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="video-text">
                        <h2>Objavte Náš Hotel & Služby</h2>
                        <p>Hotel Tour</p>
                        <a href=https://www.youtube.com/watch?v=V2LpXOKWjus class="play-btn video-popup"><img
                                src="img/play.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video Section End -->

    <!-- Gallery Section Begin -->
    <section class="gallery-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Naša Galéria</span>
                        <h2>Objavte náš Hotel</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="gallery-item set-bg" data-setbg="img/gallery/gallery-1NEW.jpg">
                        <div class="gi-text">
                            <h3>Profesionálny Personál</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="img/gallery/gallery-3NEW.jpg">
                                <div class="gi-text">
                                    <h3>Luxusné Kúpele</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="gallery-item set-bg" data-setbg="img/gallery/gallery4NEW.jpg">
                                <div class="gi-text">
                                    <h3>Vlastný šofér</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="gallery-item large-item set-bg" data-setbg="img/gallery/gallery-2NEW.jpg">
                        <div class="gi-text">
                            <h3>Najkrajšie Prostredie</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Section End -->

   <?php include_once "parts/footer.php";?>

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