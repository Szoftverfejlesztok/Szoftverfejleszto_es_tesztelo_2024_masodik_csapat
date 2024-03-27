<?php

session_start(); //olyan helyen legyen, ami minden oldalra be van require-olva, pl header, footer. De csak egyszer!

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vásár</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">

</head>
<body>
    <header class="text-center">
        <img src="nenipiac_kep.webp" alt="Piac" title="Piac">
        <img src="kocsogok_kep.jpg" alt="Piac" title="Piac">
        <img src="lanypiac_kep.jpg" alt="Piac" title="Piac">
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/fooldal.html">Kezdőlap</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Helyfoglalás</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Árusok listája</a></li>
            <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/hazirend.html">Házirend</a></li>
            <li class="nav-item"><a class="nav-link" href="http://127.0.0.1:5500/jarvanyugyisz.html">Járványügyi szabályzat</a></li>
        </ul>
    </div>
</div>
</nav>



<script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

</body>
</html>
