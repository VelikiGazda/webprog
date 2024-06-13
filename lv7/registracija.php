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
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    // Provjeri postoji li već korisničko ime
    $sql_check_username = "SELECT * FROM korisnici WHERE k_ime = '$korisnicko_ime'";
    $result_check_username = $conn->query($sql_check_username);

    if ($result_check_username->num_rows > 0) {
        $errorMessage = "Korisničko ime već postoji. Molimo odaberite drugo korisničko ime.";
    } else {
        // Dodaj korisnika
        $uloga = "kupac"; // Automatski dodijeli ulogu "kupac"
        $sql_insert_user = "INSERT INTO korisnici (ime, prezime, `k_ime`, lozinka, uloga) VALUES ('$ime', '$prezime', '$korisnicko_ime', '$lozinka', '$uloga')";

        if ($conn->query($sql_insert_user) === TRUE) {
            $successMessage = "Registracija uspješna. Prijavite se na stranici prijava.php.";
        } else {
            $errorMessage = "Greška: " . $sql_insert_user . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        input {
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
            color: #f00;
        }

        .success-message {
            color: #008000;
        }
    </style>
</head>

<body>
    <div id="form-container">
        <h2>Registracija</h2>
        <?php
        if (isset($errorMessage)) {
            echo '<p class="error-message">' . $errorMessage . '</p>';
        }
        if (isset($successMessage)) {
            echo '<p class="success-message">' . $successMessage . '</p>';
        }
        ?>
        <form method="post">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" required><br><br>
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime" required><br><br>
            <label for="korisnicko_ime">Korisničko ime:</label>
            <input type="text" id="korisnicko_ime" name="korisnicko_ime" required><br><br>
            <label for="lozinka">Lozinka:</label>
            <input type="password" id="lozinka" name="lozinka" required><br><br>
            <input type="submit" name="submit" value="Registriraj se">
        </form>
    </div>
</body>

</html>
