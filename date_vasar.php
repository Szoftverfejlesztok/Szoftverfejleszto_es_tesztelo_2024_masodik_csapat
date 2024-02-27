<?php
  // Adatbázis kapcsolódás
  require_once("dbconnect.php");

  // Felhasználók lekérdezése
  $sqlVasarok = "SELECT date_id, date FROM date_vasar";
  $queryVasarok = $dbconn->prepare($sqlVasarok);
  $queryVasarok->execute();
?>

<h2>A következő vásárok időpontjai</h2>
<h4>Kérem válassza ki, melyik időpontban szeretnek helyet foglalni.</h4>
  <select name="dates" id="dates">
    <option value="">--Válassz egy dátumot--</option>
    <?php while($row = $queryVasarok->fetch(PDO::FETCH_ASSOC)): ?>
      <option value="<?php echo $row['date_id']; ?>"><?php echo $row['date']; ?></option>
    <?php endwhile; ?>
  </select>
