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
    <title>Regisztráció</title>
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
        <main role="main" class="col-lg-9 px-md-4">
            <!--itt kell tartalommal feltölteni az oldalt -->
                <div class="container mt-3">
    
<?php
if (isset($_POST["submitRegisztral"]) && !empty($dbconn)){    
    try {
        // Űrlapról érkező adatok beolvasása
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], null);
        $name_company = $_POST['name_company'];
        $contact = $_POST['contact'];
        $telephone = $_POST['telephone'];
        $online_availability = $_POST['online_availability'];
        $productDescription = $_POST['product_description'];
        $productCategory = $_POST['product_category'];
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    } catch (Exception $e) {
        $error = "Hiba történt a helyfoglalási kérelmek lekérése közben: ".$e->getMessage(); 
    }
        
        try {
            // Felhasználói adatok beszúrása az user_data táblába
            $sqlUserData = "INSERT INTO userdata (user_name, password, name_company, contact, telephone, email, online_availability, moderator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $queryUserData = $dbconn->prepare($sqlUserData);
            $queryUserData->execute([$user_name, $password, $name_company, $contact, $telephone, strtolower($email), $online_availability, "TBD", "0"]);
    
            // Termék kategória beszúrása a product táblába
            $sqlProductCategory = "INSERT INTO product (product_category) VALUES (?)";
            $queryProductCategory = $dbconn->prepare($sqlProductCategory);
            $queryProductCategory->execute([$productCategories]);
        } catch (PDOException $e) {
            $error = "Adatbázis hiba: ".$e->getMessage(); 
        } catch (Exception $e) {
            $error = "Hiba történt a helyfoglalási kérelmek lekérése közben: ".$e->getMessage(); 
        }
    }

/*if (isset($_POST["submitRegisztral"]) && !empty($dbconn)){    
    try {
        // Űrlapról érkező adatok beolvasása
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], null);
        $name_company = $_POST['name_company'];
        $contact = $_POST['contact'];
        $telephone = $_POST['telephone'];
        $online_availability = $_POST['online_availability'];
        $productDescription = $_POST['product_description'];
        $productCategory = $_POST['product_category'];


        // SQL lekérdezés előkészítése és végrehajtása az adatok mentésére
       /* $sqlRegistration = "INSERT INTO userdata (user_name, password, name_company, contact, telephone, email, online_availability, product_description, moderator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $queryRegistration = $dbconn->prepare($sqlRegistration);
        $queryRegistration->execute([$user_name, $password, $name_company, $contact, $telephone, strtolower($email), $online_availability, "TBD", "0", "0"]);
    } catch (PDOException $e) {
        $error = "Adatbázis hiba: ".$e->getMessage(); 
    } catch (Exception $e) {
        $error = "Hiba történt a helyfoglalási kérelmek lekérése közben: ".$e->getMessage(); 
    }*/
         /*try {
            // Felhasználói adatok beszúrása az user_data táblába
            $sqlUserData = "INSERT INTO userdata (user_name, password, name_company, contact, telephone, email, online_availability, moderator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $queryUserData = $dbconn->prepare($sqlUserData);
            $queryUserData->execute([$user_name, $password, $name_company, $contact, $telephone, strtolower($email), $online_availability, "TBD", "0"]);
    
            // Termék kategória beszúrása a product táblába
            $sqlProductCategory = "INSERT INTO product (product_category) VALUES (?)";
            $queryProductCategory = $dbconn->prepare($sqlProductCategory);
            $queryProductCategory->execute([$productCategories]);
        } catch (PDOException $e) {
            $error = "Adatbázis hiba: ".$e->getMessage(); 
        } catch (Exception $e) {
            $error = "Hiba történt a helyfoglalási kérelmek lekérése közben: ".$e->getMessage(); 
        }
    }
   }*/
?>

<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">

<!-- Kliens oldali validáció-->
<script>
    function validateForm() {
        var username = document.getElementById("user_name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_conf").value;
        var companyName = document.getElementById("name_company").value;
        var contactPerson = document.getElementById("contact").value;
        var telephone = document.getElementById("telephone").value;
        var onlineAvailability = document.getElementById("online_availability").value;
        var productDescription = document.getElementById("product_description").value;
        var productCategory = document.getElementById("product_category").value;


        if (username === "") {
            alert("Kérlek add meg a felhasználónevet!");
            return false;
        }

        if (email === "") {
            alert("Kérlek add meg az email címed!");
            return false;
        } else if (!isValidEmail(email)) {
            alert("Érvénytelen email cím!");
            return false;
        }

        if (password === "") {
            alert("Kérlek add meg a jelszavad!");
            return false;
        }

        if (password !== confirmPassword) {
            alert("A jelszavak nem egyeznek!");
            return false;
        }

        if (productDescription === "") {
            alert("Kérlek válassz termék kategóriát!");
            return false;
        }

        // További validációk a cég név, kapcsolattartó, telefonszám és online elérhetőség esetén...

        return true;
    }

    function isValidEmail(email) {
        // Egyszerű email formátum validálás regex segítségével
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>
 <!--szerver oldali validáció-->
 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    // Felhasználónév ellenőrzése
   /* $username = $_POST["user_name"];
    if (strlen($username) < 4 || strlen($username) > 20) {
        $errors[] = "<span style='color: red;'>A felhasználónévnek 4 és 20 karakter között kell lennie!</span>";
    }
    if (empty($username)) {
        $errors[] = "<span style='color: red;'>A felhasználónév mező nem lehet üres!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $username)) {
        $errors[] = "<span style='color: red;'>A felhasználónévben csak betűk, számok és szóközök engedélyezettek!</span>";
    }*/
    $username = $_POST["user_name"];
    if (strlen($username) < 4 || strlen($username) > 20) {
        $errors[] = "<span style='color: red;'>A felhasználónévnek 4 és 20 karakter között kell lennie!</span>";
    }
    if (empty($username)) {
        $errors[] = "<span style='color: red;'>A felhasználónév mező nem lehet üres!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $username)) {
        $errors[] = "<span style='color: red;'>A felhasználónévben csak betűk, számok és szóközök engedélyezettek!</span>";
    }

    // Ellenőrizzük, hogy van-e már ilyen felhasználó
$sql = "SELECT * FROM user_data WHERE user_name='$username' AND (status = 0 OR status = 2 OR status = 3)";


if ($result->status > 0) {
    // Ellenőrizd a felhasználó státuszát
    while ($status = $result->fetch_assoc()) {
        if ($status["status"] == 0 || $status["status"] == 2 || $status["status"] == 3) {
            // Ez a felhasználó érvénytelen!
            $errors[] = "<span style='color: red;'>Ez a felhasználó érvénytelen!</span>";
        }
    }
}
    
    // Email cím ellenőrzése
    $email = $_POST["email"];
    if (empty($email)) {
        $errors[] = "<span style='color: red;'>Az email cím mező nem lehet üres!</span>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "<span style='color: red;'>Érvénytelen email cím formátum!</span>";
    }

    // Jelszó ellenőrzése
    $password = $_POST["password"];
    if (empty($password)) {
        $errors[] = "<span style='color: red;'>A jelszó mező nem lehet üres!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $password)) {
        $errors[] = "<span style='color: red;'>A jelszóban csak betűk, számok és szóközök engedélyezettek!</span>";
    }

    // Jelszó megerősítés ellenőrzése
    $confirmPassword = $_POST["password_conf"];
    if (strlen($password) < 6 || strlen($password) > 50) {
        $errors[] = "<span style='color: red;'>A jelszónak 6 és 50 karakter között kell lennie!</span>";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $password)) {
        $errors[] = "<span style='color: red;'>A jelszóban csak betűk, számok és szóközök engedélyezettek!</span>";
    }
    if (empty($confirmPassword)) {
        $errors[] = "<span style='color: red;'>A jelszó megerősítés mező nem lehet üres!</span>";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "<span style='color: red;'>A jelszó és a jelszó megerősítés nem egyezik meg!</span>";
    }

    // Cég név ellenőrzése
    $companyName = $_POST["name_company"];
    if (strlen($companyName) < 5 || strlen($companyName) > 50) {
        $errors[] = "<span style='color: red;'>A cég nevének 5 és 50 karakter között kell lennie!</span>";
    }
    

    // Kapcsolattartó ellenőrzése
       $contactPerson = $_POST["contact"];
    if (!preg_match("/^[a-zA-ZÁÉÍÓÖŐÚÜŰáéíóöőúüű0-9 ]*$/u", $contactPerson)) {
        $errors[] = "<span style='color: red;'>A kapcsolattartó személy nevében csak betűk, számok és szóközök engedélyezettek!</span>";
    }
    

    // Telefonszám ellenőrzése
    $telephone = $_POST["telephone"];
    if (!preg_match("/^06[0-9]{9}$/", $telephone)) {
        $errors[] = "<span style='color: red;'>Érvénytelen telefonszám formátum. Kérlek, használj 11 számjegyet, és az első két számjegy legyen 06!</span>";;
    }
    

    // Online elérhetőség ellenőrzése
    $onlineAvailability = isset($_POST["online_availability"]) ? $_POST["online_availability"] : "";
    if (!empty($onlineAvailability) && !filter_var($onlineAvailability, FILTER_VALIDATE_URL)) {
        $errors[] = "<span style='color: red;'>Az online elérhetőség mező érvénytelen URL formátumot tartalmaz!</span>";
    }
    

    //Termék leírás kitöltésének ellenőrzése
    $productDescription = $_POST["product_description"];
    if (strlen($productDescription) < 3 || strlen($productDescription) > 50) {
        $errors[] = "<span style='color: red;'>A termék leírásnak 3 és 300 karakter között kell lennie!</span>";
    }

    // Ellenőrizzük, hogy a product_category tömb létezik-e és nem üres-e
    if (!isset($_POST['product_category']) || empty($_POST['product_category'])) {
        // Termék kategóriák összefűzése szöveggé vesszővel elválasztva
        $productCategories = implode(",", $_POST['product_category']);
        
        // Hibaüzenet hozzáadása a hibák tömbjéhez
        $errors[] = "<span style='color: red;'>Válassz minimum 1 termék kategóriát!</span>";
    }

    // Ha van hiba, kiírjuk azokat
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    } else {
        // Ha nincs hiba, folytathatjuk a regisztráció feldolgozását vagy adatbázisba mentését.
        // Például: adatbázisba mentés, bejelentkeztetés stb.
        echo "<script>window.onload = function() { alert('Sikeres regisztráció!'); }</script>";
    
    }
}

?>

    <fieldset>
        <h2>Regisztráció</h2>
        <div class="profile-page">
        <div class="form profile-form">
            <form onsubmit="return validateForm()">
                <label for="user_name">Felhasználónév: *<br> (Minimum 4 betű és/vagy szám)</label>
                <input type="text" id="user_name" name="user_name" placeholder=""><br>

                <label for="email">E-mail cím: *<br> (pl.: vasar@vasar.hu)</label>
                <input type="email" id="email" name="email" placeholder=""><br>

                <label for="password">Jelszó: *<br> (Minimum 6 betű és/vagy szám)</label>
                <input type="password" id="password" name="password"><br>

                <label for="password_conf">Jelszó megerősítés: *</label>
                <input type="password" id="password_conf" name ="password_conf"><br>

                <label for="name_company">Árus/Cég név: *</label>
                <input type="text" id="name_company" name="name_company" placeholder=""><br>

                <label for="contact">Kapcsolattartó:</label>
                <input type="text" id="contact" name="contact" placeholder=""><br>

                <label for="telephone">Telefonszám: *</label>
                <input type="tel" id="telephone" name="telephone" placeholder="06701111333"><br>

                <label for="online_availability">Online elérhetőség: <br> (pl.: https://www.facebook.com/)</label>
                <input type="text" id="online_availability" name="online_availability" placeholder=""><br>

                <label for="product_description">Termék leírás * <br> (pl.: Termékkínálatunkban többféle méz megtalálható, többek között akác, repce, vegyes virágméz)</label> 
                <input type="text" id="product_description" name="product_description" placeholder="">

                <label for="product_category">Termék kategória: * </label> <br>
                <label for="mez">Méz</label>
                <input type="checkbox" name="product_category[]" id="mez" value="mez">
                <br>
                <label for="szerszam">Kerti szerszám</label>
                <input type="checkbox" name="product_category[]" id="szerszam" value="szerszam">
                <br>
                <label for="vetomag">Vetőmag</label>
                <input type="checkbox" name="product_category[]" id="vetomag" value="vetomag">
                
                <br>   
                <br>

                <input type="submit" value="Küldés" name="submitRegisztral">
            </form>
        </div>
        </div>
    </fieldset>

    
    
    <?php 
        displayMessages($error, $msg);
        require_once("footer.html"); 
    ?>
        
        <script src="https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
