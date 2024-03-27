<?php
// Adatbázis kapcsolódás
require_once("dbconnect.php"); 
?>

<h2>A következő vásárok időpontjai</h2>
<h4>Kérem válassza ki, melyik időpontban szeretne helyet foglalni.</h4>
<select id="vasarDatumLista">
    <option value=''>--Válasszon egy dátumot--</option>
    <?php
        // Lekérdezés a vásárok időpontjait tartalamzó legördülő lista feltöltéséhez
        $sqlVasarok = "SELECT date_id, date FROM date_vasar";
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
            xhr.open('GET', 'helyek.php?dateId=' + selectedDateId, true);
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
        window.location.href = `megerosites.php?selectedDateId=${selectedDateId}&selectedHelyId=${selectedHelyId}`;
    });

</script>