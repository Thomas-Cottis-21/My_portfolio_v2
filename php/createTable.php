<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;, username, password");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE Clients (
            contactID INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NULL,
            email VARCHAR(100) NULL,
            comments VARCHAR(600) NULL,
            dateSent DATETIME DEFAULT CURRENT_TIMESTAMP);";

    $conn->exec($sql);
    echo "Table has been created successfully. ";

} catch (PDOException $error) {
    echo "Database connection: failed" . "<br>" . $error->getMessage();
}

$conn = null;
