<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Početna stranica</title>
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

        #content-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1, p, ul {
            margin: 0;
            padding: 0;
        }

        ul {
            list-style-type: none;
            padding: 10px 0;
        }

        li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin: 10px;
            transition: background-color 0.3s;
        }

        a:hover {
            color: #fff;
            background-color: #4CAF50;
        }

        .btn-login {
            background-color: #90ee90 ;
        }

        .btn-register {
            background-color: #90ee90 ;
        }
    </style>
</head>
<body>
    <div id="content-container">
        <h1>Dobrodošli na početnu stranicu interaktivnog skladišta!</h1>
        <p>Ovdje možete pronaći linkove za prijavu i registraciju:</p>
        <ul>
            <li><a href="prijava.php" class="btn btn-login">Prijava</a></li>
            <li><a href="registracija.php" class="btn btn-register">Registracija</a></li>
        </ul>
    </div>
</body>
</html>
