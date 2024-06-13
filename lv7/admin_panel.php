<?php
session_start();

// Provjeri je li korisnik prijavljen kao admin
if (!isset($_SESSION['korisnik']) || $_SESSION['uloga'] !== 'admin') {
    // Ako nije admin, preusmjeri ga na prijavu.php
    header("Location: prijava.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
</head>
<body>
    <h1>Dobrodošli u admin panel</h1>
    <h2>Odaberite što želite napraviti:</h2>
    <ul>
        <li><a href="dodaj_proizvod.php">Dodaj proizvod</a></li>
        <li><a href="brisanje_proizvoda.php">Obriši proizvod</a></li>
        <li><a href="ispis.php">Pregled svih proizvoda</a></li>
    </ul>
    <br>
    <a href="odjava.php">Odjava</a>
</body>
</html>
