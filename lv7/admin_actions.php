<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skladiste";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnik'])) {
    // Ako nije, preusmjeri ga na prijava.php
    header("Location: prijava.php");
    exit();
}

// Provjeri ulogu korisnika
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == 'kupac') {
    // Ako je korisnik kupac, preusmjeri ga na ispis.php
    header("Location: ispis.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_product'])) {
        // Kod za dodavanje proizvoda
        $naziv = $_POST['proizvod'];
        $opis = $_POST['opis'];
        $kolicina = $_POST['kolicina'];
        $cijena = $_POST['cijena'];

        $sql = "INSERT INTO proizvodi (proizvod, opis, kolicina, cijena) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssdd", $naziv, $opis, $kolicina, $cijena);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Proizvod uspješno dodan.";
            } else {
                echo "Greška prilikom dodavanja proizvoda.";
            }

            $stmt->close();
        } else {
            echo "Greška: " . $conn->error;
        }
    } elseif (isset($_POST['delete_product'])) {
        // Kod za brisanje proizvoda
        $product
