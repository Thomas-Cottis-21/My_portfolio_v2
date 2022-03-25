<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myFirstDatabase";
    try {
        $conn = new PDO("mysql:host=$hostname;dbname=$dbname;,username, password");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$sql = "CREATE DATABASE myFirstDatabase";

        echo "Database connection: successful";

        //$conn->exec($sql);

        echo "Database created successfully<br>";
    } catch(PDOException $error) {
        echo "Database connection: failed" . $error -> getMessage();
    }

    $conn = null;
