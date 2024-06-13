<?php
session_start();

// Provjera postojanja košarice u sesiji
if (!isset($_SESSION['kosarica'])) {
    $_SESSION['kosarica'] = array(); // Inicijalizacija košarice ako ne postoji
}

// Dodavanje proizvoda u košaricu ako je korisnik pritisnuo gumb "Dodaj u košaricu"
if (isset($_POST['action']) && $_POST['action'] == 'Dodaj u košaricu') {
    $proizvod_id = $_POST['proizvod_id'];

    // Dohvat proizvoda iz baze, ovisno o vašoj implementaciji
    // Primjer:
    $sql_proizvod = "SELECT * FROM proizvodi WHERE id = $proizvod_id";
    $result_proizvod = $conn->query($sql_proizvod);

    if ($result_proizvod->num_rows == 1) {
        $row = $result_proizvod->fetch_assoc();
        // Dodavanje proizvoda u košaricu
        $_SESSION['kosarica'][] = array(
            'id' => $row['id'],
            'naziv' => $row['proizvod'],
            'cijena' => $row['cijena']
        );
        echo "<p>Proizvod dodan u košaricu: " . htmlspecialchars($row['proizvod']) . "</p>";
    } else {
        echo "Proizvod nije pronađen.";
    }
}

// Ispis sadržaja košarice
echo "<h2>Košarica</h2>";
if (!empty($_SESSION['kosarica'])) {
    echo "<table>";
    echo "<tr><th>Naziv</th><th>Cijena</th></tr>";
    $ukupna_cijena = 0;
    foreach ($_SESSION['kosarica'] as $proizvod) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($proizvod['proizvod']) . "</td>";
        echo "<td>" . htmlspecialchars($proizvod['cijena']) . " kn</td>";
        echo "</tr>";
        $ukupna_cijena += $proizvod['cijena'];
    }
    echo "</table>";
    echo "<p>Ukupna cijena: " . $ukupna_cijena . " kn</p>";

    // Forma za odabir načina plaćanja i potvrdu narudžbe
    echo "<form method='post' action='narudzba.php'>";
    echo "<label for='placanje'>Odaberi način plaćanja:</label>";
    echo "<select id='placanje' name='placanje' required>";
    echo "<option value='kartica'>Kartica</option>";
    echo "<option value='gotovina'>Gotovina</option>";
    echo "</select><br><br>";
    echo "<input type='submit' name='action' value='Naruči'>";
    echo "</form>";
} else {
    echo "<p>Košarica je prazna.</p>";
}


?>
