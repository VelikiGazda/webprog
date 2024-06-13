<?php
session_start();

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnik'])) {
  // Ako nije, preusmjeri ga na prijava.php
  header("Location: prijava.php");
  exit(); // Ovo osigurava da se ostatak koda ne izvršava nakon preusmjeravanja
}
//printf("%s",$_SESSION['uloga']);
if (isset($_SESSION['korisnik']) && $_SESSION['uloga'] !== 'admin') {
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
  $naziv = $_POST['naziv'];
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
      
        // Dodaj redirekciju na unos.php i poruku o povratku
      echo '<br><br><a href="unos.php">Povratak na unos</a>';
      echo '<br><a href="ispis.php">Prikaz svih proizvoda</a>';
        

    } else {
      echo "Greška prilikom dodavanja proizvoda.";
    }

    $stmt->close();
  } else {
    echo "Greška: " . $conn->error;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dodaj proizvod</title>
</head>
<body>
  <h2>Dodaj novi proizvod</h2>
  <form method="post">
    <label for="naziv">Naziv:</label>
    <input type="text" id="naziv" name="naziv"><br><br>
    <label for="opis">Opis:</label>
    <textarea id="opis" name="opis"></textarea><br><br>
    <label for="kolicina">Količina:</label>
    <input type="number" id="kolicina" name="kolicina"><br><br>
    <label for="cijena">Cijena:</label>
    <input type="number" id="cijena" name="cijena"><br><br>
    <input type="submit" name="submit" value="Dodaj proizvod">
  </form>
  <br>
  <a href="ispis.php">Prikaži sve proizvode</a>
  <br>
  <a href="odjava.php">Odjava</a>
</body>
</html>
