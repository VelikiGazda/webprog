<?php
session_start();

if (isset($_POST['action']) && $_POST['action'] == 'Naruči') {
    // Provjera postojanja košarice u sesiji
    if (!isset($_SESSION['kosarica']) || empty($_SESSION['kosarica'])) {
        echo "Košarica je prazna. Nema proizvoda za narudžbu.";
        exit();
    }

    // Simulacija narudžbe - ovdje bi se obično spremili podaci u bazu ili drugi sustav
    $placanje = $_POST['placanje'];

    // Očisti košaricu nakon uspješne narudžbe
    $_SESSION['kosarica'] = array();

    // Ispis potvrde
    echo "<h2>Narudžba izvršena</h2>";
    echo "<p>Hvala vam na narudžbi!</p>";
    echo "<p>Način plaćanja: " . htmlspecialchars($placanje) . "</p>";
    echo "<p><a href='ispis.php'>Povratak na ispis proizvoda</a></p>";
} else {
    echo "Nepoznata akcija.";
}

?>
