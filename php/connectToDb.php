<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected successfully ";

        $sql = "INSERT INTO clients (firstname, lastname, email) VALUES ('Thomas', 'Cottis', 'email')";

        $conn->exec($sql);
        
    } catch(PDOException $error) {
        echo $sql . $error->getMessage();
    }

    $conn = null;
?>