<?php
session_start();

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnik'])) {
  // Ako nije, preusmjeri ga na prijava.php
  header("Location: prijava.php");
  exit(); // Ovo osigurava da se ostatak koda ne izvršava nakon preusmjeravanja
}

// Provjeri ulogu korisnika
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == 'kupac') {
  // Ako je korisnik kupac, preusmjeri ga na ispis.php
  header("Location: ispis.php");
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

if (isset($_SESSION['korisnik'])) {
  echo "<h1>Dobrodošao " . $_SESSION['korisnik'] . "!</h1>";
}

if (isset($_POST['submit'])) {
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
      $successMessage = "Proizvod uspješno dodan.";

      // Provjeri opet ulogu korisnika i preusmjeri ga ako je kupac
      if ($_SESSION['uloga'] == 'kupac') {
        header("Location: ispis.php");
        exit();
      }
    } else {
      $errorMessage = "Greška prilikom dodavanja proizvoda.";
    }

    $stmt->close();
  } else {
    $errorMessage = "Greška: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj proizvod</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h1 {
            color: #333;
        }

        #form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        textarea,
        select {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #dc143c; 
        }
        .success-message {
            color: #00ff7f;
        }
    </style>
</head>
<body>
    <div id="form-container">
        <?php
        if (isset($_SESSION['korisnik'])) {
            echo "<h1>Dobrodošao " . $_SESSION['korisnik'] . "!</h1>";
        }
        ?>
        <h2>Dodaj novi proizvod</h2>
        <?php
        if (isset($errorMessage)) {
            echo '<p class="error-message">' . $errorMessage . '</p>';
        }
        if (isset($successMessage)) {
            echo '<p class="success-message">' . $successMessage . '</p>';
        }
        ?>
        <form method="post">
            <label for="naziv">Naziv:</label>
            <input type="text" id="naziv" name="naziv" required><br><br>
            <label for="opis">Opis:</label>
            <textarea id="opis" name="opis" required></textarea><br><br>
            <label for="kolicina">Količina:</label>
            <input type="number" id="kolicina" name="kolicina" required><br><br>
            <label for="cijena">Cijena:</label>
            <input type="number" id="cijena" name="cijena" required><br><br>
            <input type="submit" name="submit" value="Dodaj proizvod">
        </form>
        <br>
        <a href="ispis.php">Prikaži sve proizvode</a>
        <br>
        <a href="odjava.php">Odjava</a>
    </div>
</body>
</html>
