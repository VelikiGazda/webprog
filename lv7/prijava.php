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

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM korisnici WHERE k_ime='$username' AND lozinka='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['korisnik'] = $row['k_ime'];

        if ($row['uloga'] == 'admin') {
            $_SESSION['uloga'] = 'admin';
            header("Location: admin_panel.php");
            exit();
        } else {
            $_SESSION['uloga'] = 'kupac';
            header("Location: ispis.php");
            exit();
        }
    } else {
        echo "Pogrešno korisničko ime ili lozinka.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava</title>
</head>
<body>
    <h2>Prijava</h2>
    <form method="post">
        <label for="username">Korisničko ime:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Lozinka:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" name="submit" value="Prijavi se">
    </form>
</body>
</html>
