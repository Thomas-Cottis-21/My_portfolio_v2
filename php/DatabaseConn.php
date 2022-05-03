<?php 
    $servername = "localhost";
    $username = "homasan5_thomas";
    $password = "JohanaRamirez21$$";
    $dbname = "homasan5_portfolio_clients_database";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected successfully ";
        
    } catch(PDOException $error) {
        echo $sql . $error->getMessage();
    }

    $conn = null;
?>