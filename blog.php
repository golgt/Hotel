<?php
include_once "parts/header.php";
include_once "classes/BlogManager.php";
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=hotel_u_ovesky;charset=utf8", "root", "", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$manager = new BlogManager($pdo);
$posts = $manager->getAllPosts();
?>

<body>
    <!-- Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php"; ?>

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <h2>Blog</h2>
                        <div class="bt-option">
                            <a href="./index.php">Domov</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Section -->
    <section class="blog-section blog-page spad">
        <div class="container">
            <div class="row">
                <?php foreach ($posts as $post): ?>
                    <?= $post->renderCard(); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

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

    <!-- JS Plugins -->
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
