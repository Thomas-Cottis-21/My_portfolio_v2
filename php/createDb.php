<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;, username, password");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Database status: ";

        echo "Database connection was successful<br>";
    } catch (PDOException $error) {
        echo "Database connection: failed" . "<br>" . $error -> getMessage();
    }

    $conn = null;