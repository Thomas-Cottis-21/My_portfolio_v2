<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;, username, password");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO clients (name, email, comments)
    VALUES ('Isabel Montoya', 'i@m.com', 'YO tmbn');";

    $conn->exec($sql);

    $last_id = $conn -> lastInsertId();
    echo "A new record was added. The last insert ID is " . $last_id . "<br>";
    echo "Data has been inserted successfully. ";
} catch (PDOException $error) {
    echo "Data insertion: failed" . "<br>" . $error->getMessage();
}

$conn = null;
