<nav class="sidebar navbar-expand-lg navbar-dark custom-navbar d-lg-block col-md-2">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav flex-column">
            <?php if (!isset($_SESSION["user"])) {  //Ha ki vagyok jelentkezve, akkor a bejelentkezés és a regisztráció látható.
                    echo '
            <li class="nav-item active">
                <!--Bejelentkezés-->
                <a class="nav-link text-white" href="login.php">Bejelentkezés</a>
            </li>
            <li class="nav-item active">
                <!--Regisztráció-->
                <a class="nav-link text-white" href="registration_form.php" >Regisztráció</a>
            </li>';
                } else {   //Ha be vagyok lépve, akkor legyen látható a Profil, a Kijelentkezés. Az Adminisztrátor - Felhasználó kezelés és a Adminisztrátor - Helyfoglalás kezelés csak bizonyos feltételekkel.
                
                    echo '
            <li class="nav-item active">
                <!--Profil-->
                <a class="nav-link text-white" href="profile.php">Profil</a>
            </li>
            <li class="nav-item">
                <!--Helyfoglalási kérelem-->
                <a class="nav-link text-white" href="place_reservation.php">Helyfoglalási kérelem</a>
            </li>
            <li class="nav-item">
                <!--Korábbi helyfoglalásaim-->
                <a class="nav-link text-white" href="my_reservation.php">Helyfoglalásaim</a>
             </li>';
                    if ($_SESSION["user"]["moderator"] == 1) {
                        echo '
                    <li class="nav-item active">
                        <!--Adminisztrátor: akkor látható, ha be van jelentkezve az admin-->
                        <a class="nav-link text-white" href="admin_users.php">Adminisztrátor - Felhasználó kezelés</a>
                    </li>
                    <li class="nav-item active">
                        <!--Adminisztrátor: akkor látható, ha be van jelentkezve az admin-->
                        <a class="nav-link text-white" href="admin_reservation.php">Adminisztrátor - Helyfoglalás kezelése</a>
                    </li>
                    <li class="nav-item active">
                        <!--Adminisztrátor: akkor látható, ha be van jelentkezve az admin-->
                        <a class="nav-link text-white" href="admin_new_product.php">Adminisztrátor - Új termék kategória</a>
                    </li>';
                    }
                    echo '
            <li class="nav-item active">
                <!--Kijelentkezés-->
                <a class="nav-link text-white" href="index.php?logout">Kijelentkezés</a>
            </li>';
                }
                ?>
        </ul>
    </div>
</nav