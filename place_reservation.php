<?php
$error = "";        // hibakezelés
$msg = ""; 

require_once("dbconnect.php");
session_start(); 

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
</head>
<body>

    <?php require_once("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <?php require_once("sidebar_menu.php"); ?>


            <!-- Main Content -->
            <main role="main" class="ml-sm-auto col-lg-8 px-md-4">
                <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3" id="place_reservation">
                    <h3>Kérem válassza ki, melyik időpontban szeretne helyet foglalni!</h3>
                    <select id="vasarDatumLista">
                        <option value=''>--Válasszon egy dátumot--</option>
                        <?php
                            // Lekérdezés a vásárok időpontjait tartalamzó legördülő lista feltöltéséhez
                            $sqlVasarok = "SELECT date_id, date FROM date_market WHERE DATE(date) >= CURRENT_DATE;";
                            $queryVasarok = $dbconn->prepare($sqlVasarok);
                            $queryVasarok->execute();

                            // A vásárok időpontjainak kiírása a legördülő listába
                            while($row = $queryVasarok->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row["date_id"] . "'>" . $row["date"] . "</option>";
                            }
                        ?>
                        
                    </select>

                    <h4 id="szabadHelyekCimke" style="display: none;">Ebben az időpontban a következő helyek szabadok:</h4>
                    <select id="szabadHelyekLista" style="display: none;">
                        <!-- Placeholder a szabad helyek legördülő listához -->
                    </select>

                    <input type="submit" value="Kiválasztom" name="submitHely" id="submitHely" style="display: none;">

                    <script>
                        const vasarDatumLista = document.getElementById('vasarDatumLista');
                        const szabadHelyekLista = document.getElementById('szabadHelyekLista');

                        vasarDatumLista.addEventListener('change', function() {
                            submitHely.style.display = 'none';
                            const selectedDateId = vasarDatumLista.value;
                            if(selectedDateId != "") {
                                // AJAX kérés a szabad helyek legördülő lista feltöltésére
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState === XMLHttpRequest.DONE) {
                                        if (xhr.status === 200) {
                                            szabadHelyekLista.innerHTML = xhr.responseText;
                                            szabadHelyekCimke.style.display = 'block'; // Szabad helyek cimke megjelenítése
                                            szabadHelyekLista.style.display = 'block'; // Szabad helyek legördülő lista megjelenítése
                                        } else {
                                            console.error('Hiba történt a szerver válaszában.');
                                        }
                                    }
                                };
                                xhr.open('GET', 'places.php?dateId=' + selectedDateId, true);
                                xhr.send();
                            } else {
                                szabadHelyekLista.style.display = 'none';
                                szabadHelyekCimke.style.display = 'none';
                            }
                        });

                        szabadHelyekLista.addEventListener('change', function() {
                            const selectedHelyId = szabadHelyekLista.value;
                            if(selectedHelyId != "") {
                                submitHely.style.display = 'block'; // Kiválasztom gomb megjelenítése
                            } else {
                                submitHely.style.display = 'none';
                            }
                        });

                        submitHely.addEventListener('click', function() {
                            const selectedDateId = vasarDatumLista.value;
                            const selectedHelyId = szabadHelyekLista.value;
                            // Átnavigálunk a megerosites.php és átadjuk a selectedDateId és a selectedHelyId értékét
                            window.location.href = `confirmation.php?selectedDateId=${selectedDateId}&selectedHelyId=${selectedHelyId}`;
                        });




                    </script>
                    <div id="market_picture">
                        <img src="market_picture.png" alt="piac kép">
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>
</html>
