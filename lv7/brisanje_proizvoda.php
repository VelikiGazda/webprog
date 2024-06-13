<?php
session_start();

// Provjeri je li korisnik prijavljen kao admin
if (!isset($_SESSION['korisnik']) || $_SESSION['uloga'] !== 'admin') {
    // Ako nije admin, preusmjeri ga na prijavu.php ili index.php
    header("Location: prijava.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skladiste";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Brisanje proizvoda ako je poslan zahtjev za brisanje
if (isset($_POST['delete_product'])) {
    $id = $_POST['product_id'];

    $sql_delete = "DELETE FROM proizvodi WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Proizvod je uspješno obrisan.";
        } else {
            echo "Greška prilikom brisanja proizvoda.";
        }

        $stmt->close();
    } else {
        echo "Greška: " . $conn->error;
    }
}

// Dohvaćanje svih proizvoda iz baze podataka
$sql_select_products = "SELECT * FROM proizvodi";
$result = $conn->query($sql_select_products);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel - Brisanje proizvoda</title>
    <style>
        /* Stilizacija */
    </style>
</head>
<body>
    <h1>Admin panel - Brisanje proizvoda</h1>

    <!-- Prikaz svih proizvoda -->
    <div class="product-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<h3>' . htmlspecialchars($row['naziv']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['opis']) . '</p>';
                echo '<p>Količina: ' . $row['kolicina'] . '</p>';
                echo '<p>Cijena: ' . $row['cijena'] . '</p>';
                echo '<form method="post">';
                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                echo '<button type="submit" name="delete_product">Obriši proizvod</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "Nema proizvoda za prikaz.";
        }
        ?>
    </div>

    <br>
    <!-- Dodaj linkove ili gumbe za druge administrativne akcije -->
    <a href="dodaj_proizvod.php">Dodaj novi proizvod</a><br>
    <a href="odjava.php">Odjava</a>
</body>
</html>
