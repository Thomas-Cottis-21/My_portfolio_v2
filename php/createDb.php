<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;,$username, $password");

        $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        echo "Database status: failed " . $error -> getMessage();
    }