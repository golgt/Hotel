<?php
include_once "parts/header.php";
?>

<body>
    <div id="preloder"><div class="loader"></div></div>
    <?php include_once "parts/navbar.php"; ?>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registrácia</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        // Zobrazenie chybových správ, ak existujú
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        
                        // Zobrazenie správy o úspechu, ak existuje
                        if (isset($_GET['success'])) {
                            echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
                        }
                        ?>
                        
                        <form action="auth/register_user.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="name">Meno:</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Zadajte meno" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="lastname">Priezvisko:</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Zadajte priezvisko" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gender" class="form-label">Pohlavie:</label><br>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="" disabled selected>-- Vyberte pohlavie --</option>
                                    <option value="male">Muž</option>
                                    <option value="female">Žena</option>
                                </select>
                            </div><br><br>
                            
                            <div class="form-group mb-3">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Zadajte email" required>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="password">Heslo:</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Zadajte heslo" required>
                            </div>
                                  
                            <div class="text-center">
                                <div class="room-item">
                                    <div class="ri-text">
                                        <button type="submit" class="primary-btn">Registrovať</button>
                                        <div class="mt-3 text-center">
                                            Už máte účet? <a href="login.php" class="primary-btn"> Prihlásiť sa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
