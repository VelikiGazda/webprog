<?php
session_start();

// Provjeri je li korisnik prijavljen
if (!isset($_SESSION['korisnik'])) {
    // Ako nije, preusmjeri ga na prijava.php
    header("Location: prijava.php");
    exit(); // Ovo osigurava da se ostatak koda ne izvršava nakon preusmjeravanja
}

// Provjeri ulogu korisnika
if (isset($_SESSION['uloga']) && $_SESSION['uloga'] == 'admin') {
    // Ako je korisnik admin, preusmjeri ga na admin panel
    header("Location: admin_panel.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "skladiste";

// Povezivanje na bazu podataka
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dohvati sve proizvode iz baze podataka
$sql = "SELECT * FROM proizvodi";
$result = $conn->query($sql);

// Ako ima rezultata, prikaži ih u tablici
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ispis proizvoda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            text-align: right;
            margin-top: 10px;
        }
        .actions button {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .actions button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Popis proizvoda</h2>
        <table>
            <tr>
                <th>Naziv</th>
                <th>Opis</th>
                <th>Količina</th>
                <th>Cijena</th>
                <th>Akcija</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['proizvod'] . "</td>";
                    echo "<td>" . $row['opis'] . "</td>";
                    echo "<td>" . $row['kolicina'] . "</td>";
                    echo "<td>" . number_format($row['cijena'], 2, ',', '.') . " kn</td>";
                    echo "<td>";
                    echo '<form method="post" action="kosarica.php">';
                    echo '<input type="hidden" name="id_proizvoda" value="' . $row['id'] . '">';
                    echo '<input type="hidden" name="proizvod" value="' . $row['proizvod'] . '">';
                    echo '<input type="hidden" name="cijena" value="' . $row['cijena'] . '">';
                    echo '<button type="submit" name="dodaj_u_kosaricu">Dodaj u košaricu</button>';
                    echo '</form>';
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nema dostupnih proizvoda</td></tr>";
            }
            ?>
        </table>
        <div class="actions">
            <button onclick="window.location.href='kosarica.php'">Prikaži košaricu</button>
            <button onclick="window.location.href='odjava.php'">Odjava</button>
        </div>
    </div>
</body>
</html>

<?php
// Zatvaranje konekcije
$conn->close();
?>
