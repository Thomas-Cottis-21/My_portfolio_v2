<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "test";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$dbname;, username, password");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM clients";

    $conn->exec($sql);

    echo "The data currently stored in the database: <br>\n";
    
    foreach ($conn->query($sql) as $line) {
        echo $line['contactID'] . " | ";
        echo $line['name'] . " | ";
        echo $line['email'] . " | ";
        echo $line['comments'] . " | ";
        echo $line['dateSent'] . "<br>";
    }
} catch (PDOException $error) {
    echo "Data display: failed" . "<br>" . $error->getMessage();
}

$conn = null;
