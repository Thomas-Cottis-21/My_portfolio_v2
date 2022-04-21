<?php
//starting session
    session_start();

//create conenction to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

//filter incoming data
    function data_filter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    $loginUsername = data_filter($_POST["username"]);

    $loginPassword = data_filter($_POST["password"]);

    $_SESSION["post-data"] = $_POST;

//try and catch to connect to database or return and show error
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Database connection successful -> Access Granted!";

        $stmt = $conn->prepare('SELECT accountId, username, password, name FROM accounts WHERE username = :username');

        $stmt->bindParam(":username", $loginUsername);
        $stmt->execute();

        $user = $stmt->fetch();

        $userId = $user[0];
        $userName = $user[1];
        $userPassword = $user[2];
        $userRealName = $user[3];

        if ($userName === $loginUsername &&  $userPassword === $loginPassword) {
            header("Location: home.php");
            echo "Access Granted!";
            session_regenerate_id();
            $_SESSION["loggedin"] = TRUE;
            $_SESSION["name"] = $userRealName;
            $_SESSION["id"] = $userId;
        } else {
            header("Location: /index.php");
            echo "access denied";
        }
        
    } catch(PDOException $error) {
        header("Location: /index.php");
        echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";
        echo "Database failed to connect";
    }

    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>What the user entered: </h1>
        <h2><?=$loginUsername?></h2><br>
        <h2><?=$loginPassword?></h2>
        <h1>What is in the database saved under their account row: </h1>
        <h2><?=$userName?></h2>
        <h2><?=$userPassword?></h2>
        <h1>What the array user is fetching from the database</h1>
        <h2><?=print_r($user)?></h2>
        <h2></h2>
</body>
</html>