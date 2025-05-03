<?php include_once "parts/header.php";
    session_start();
?>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php include_once "parts/navbar.php";?>

    <!-- Contact Section Begin -->
    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Kontaktné Informácie</h2>
                        <p>Ak sa Vám pobyt u nás páčil alebo nie určite budeme radi za každfú správu čo nám tu zanecháte.
                            Podľa Vašich pocitov sa pokúsime upraviť služby kroré ponúkame. </p>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="c-o">Adresa:</td>
                                    <td>Pod Zvoničkou 923, 968 01 Nová Baňa</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Telefón:</td>
                                    <td>(12) 345 67890</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Email:</td>
                                    <td>martin.ovcarcik@student.ukf.sk</td>
                                </tr>
                                <tr>
                                    <td class="c-o">Fax:</td>
                                    <td>+(12) 345 67890</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form action="db/spracovanieFormulara.php" method="post" class="contact-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="meno" placeholder="Vaše Meno">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="email" placeholder="váš Email">
                            </div>
                            <div class="col-lg-12">
                                <textarea name="sprava" placeholder="Vaša Správa"></textarea>
                                <button type="submit">Odoslať</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7487.840352435704!2d18.643677047470838!3d48.43059620030478!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476ad5e70a30e459%3A0x23dde5c5388ce10f!2sBufet%20a%20Ferrata%20Zvoni%C4%8Dka!5e0!3m2!1ssk!2ssk!4v1746257767052!5m2!1ssk!2ssk" 
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

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