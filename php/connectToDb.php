<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Database connected successfully";

        $stmt = $conn->prepare("INSERT INTO Clients (firstname, lastname, email)
        VALUES (:firstname, :lastname, :email)");
        $stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);
        $stmt->bindParam(":lastname", $lastName, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        $firstName = "testfname";
        $lastName = "testlName";
        $email = "testEmail";
        $stmt ->execute();


    } catch(PDOException $error) {
        echo "Connection failed: " . "/n" . $error->getMessage();
    }
    $conn = null;
?>