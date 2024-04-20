   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

   <header class="text-center">
        <img src="header_picture.jpg" alt="Piac" title="Piac">
    </header>
  
 <body>  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Kezdőlap</a></li>
            
            <li class="nav-item"><a class="nav-link" href="sellers.php">Árusok listája</a></li>
            <li class="nav-item"><a class="nav-link" href="houserule.php">Házirend</a></li>
            <li class="nav-item"><a class="nav-link" href="epidemiological_regulation.php">Járványügyi szabályzat</a></li>
            <li class="nav-item">
            <form method="GET" action="search.php">
                <label for="keres"></label>
                <input type="text" name="keres" id="keres" placeholder="Termékkategória">
                <button type="submit">Keresés</button>
            </form>
            </li>
        </ul>
    </div>
</div>
</nav>
<!-- Esetleges hibát megjelenítő paragraph -->
<p class="text-white bg-danger p-3 d-none text-center" id="errorMessage" style="font-size: 1.5rem;"></p>
<!-- Esetleges üzenetet megjelenítő paragraph -->
<p class="text-white bg-success p-3 d-none text-center" id="confirmMessage" style="font-size: 1.5rem;"></p>


<?php
// Kirja a $error változó tartalmát, ha nem üres
function displayMessages($error, $msg) {
    if (!empty($error)) {
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '    var errorMessage = document.getElementById("errorMessage");';
        echo '    errorMessage.textContent = "'.htmlspecialchars($error).'";';
        echo '    errorMessage.classList.remove("d-none");';
        echo '});';
        echo '</script>';
    }
    if (!empty($msg)) {
        echo '<script>';
        echo 'document.addEventListener("DOMContentLoaded", function() {';
        echo '    var confirmMessage = document.getElementById("confirmMessage");';
        echo '    confirmMessage.textContent = "'.htmlspecialchars($msg).'";';
        echo '    confirmMessage.classList.remove("d-none");';
        echo '});';
        echo '</script>';
    }
}
?>

</body>
</html>