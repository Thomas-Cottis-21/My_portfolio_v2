<?php
ob_start();


    require "databaseConnection.php";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected successfully ";

        $stmt = $conn->prepare("SELECT `clientId` FROM `clients`");
        $stmt->execute();

        /* $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); */
        echo "<br/>";

        $result = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        /* var_dump($result); */

        foreach ($result as $id) {
            echo "<p>$id</p>";
        }

        $clientId = $_POST["clientId"];

        $currentStatus = $_POST["status"];

        echo "<br/>" . $currentStatus;

        echo "<br/>" . $clientId;

        $stmt2 = $conn->prepare("UPDATE `clients` SET `status`= '$currentStatus' WHERE '$clientId' = `clientId`");

        $stmt2->execute();


        if (isset($_POST["Delete"])) {
            $stmt3 = $conn->prepare("DELETE FROM `clients` WHERE $clientId = `clientId`");

            $stmt3->execute();
        } else {
            echo "<script>console.log('This is the else stmt in the delete if stmt');</script>";
        }

        header("Location: home.php");
        
    } catch(PDOException $error) {
        echo $error->getMessage();
    }

    $conn = null;
?>