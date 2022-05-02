<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "my_portfolio_v2_test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected successfully ";
        
    } catch(PDOException $error) {
        echo $sql . $error->getMessage();
    }

    $conn = null;
?>