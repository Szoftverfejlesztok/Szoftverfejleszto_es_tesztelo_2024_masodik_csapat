<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

//itt fontos a sorrend:
if (isset($_GET["logout"])){
    // ki kell venni a felhasználói adatokat a sessionből és így tudja hogy kijelentkezni akar (session destroy lerombol, session unset = kiüríti a tartalmát pl nyelvi beállítás is lehet benne
    unset($_SESSION["user"]);  // a sessionben lévő user tömböt megszünteti
    setcookie("id","",time()-1);//törli a cookiekat a kijelentkezéssel, cookiet nem lehet törölni csak lejártra állítani
    unset($_COOKIE["id"]);  //szerver oldali tömbből is kidobjuk a cookikat
    $msg = "Sikeres kijelentkezés!";
}

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="main.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/fjs"></script>
    <script>
        // helyfoglalás felugró ablak
        window.onload = function() {
            var params = new URLSearchParams(window.location.search);
            var foglalas = params.get('foglalas');
            var message = '';
            if (foglalas == 1) {
                document.getElementById("popupOk").style.display = "block";
            } else if (foglalas == 0){
                document.getElementById("popupErr").style.display = "block";
            }
            if (message) {
                alert(message);
            }
        };
    </script>
</head>
<body>

    <?php require_once("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once("sidebar_menu.php"); ?>

            <!-- Main Content -->
           <main role="main" class="col-lg-10 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                    <div class="container mt-3">
                        
                        <h1>VÁSÁR</h1><br><br>

                        <?php require_once("admin_next_vasar.php"); ?>
                        
                        <figure>
                            <div class = google-map>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2760.711539595866!2d19.867224776185033!3d46.2161930710962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47437d322b2fa027%3A0x15a3d790a61e4b55!2zTcOzcmFoYWxvbSB2w6Fzw6FydMSXcg!5e0!3m2!1shu!2shu!4v1708362443078!5m2!1shu!2shu" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                                 <figcaption>Helyszín: 6782 Mórahalom, Szegedi út 114.</figcaption>
                        </figure>
                                                                    
                        </div>
                        <!-- helyfoglalás felugró ablak -->
                        <div id="popupOk" class="popup_index">
                            <h2>Köszönjük kérelmét!</h2>
                            <h5>A foglalása adminisztrátori jóváhagyásra vár.</h5>
                            <h5>Állapotát a helyfoglalásaim menüpontban tekintheti meg.</h5>
                            <span class="close_index" id="closeOk">&times;</span>
                        </div>
                        <div id="popupErr" class="popup_index">
                            <h3>Hiba történt a foglalás során!</h3>
                            <h5>Kérjük próbálja meg újra!</h5>
                            <span class="close_index" id="closeErr">&times;</span>
                           
                        </div>
                        <script>
                        document.getElementById('closeOk').onclick = function() {
                        document.getElementById('popupOk').style.display = 'none';
                        }

                        document.getElementById('closeErr').onclick = function() {
                        document.getElementById('popupErr').style.display = 'none';
                        };
                        </script>

                    </div>
            </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>
</body>
</html>
