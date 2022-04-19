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

        echo "Database connection successful -> ";

        $stmt = $conn->prepare('SELECT password FROM accounts WHERE username = ?');

        $stmt->execute([$loginUsername]);

        $user = $stmt->fetch();

        if ($user) {
            echo "access granted";
        } else {
            echo "access denied";
        }
        
    } catch(PDOException $error) {
        echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";
        echo "Database failed to connect";
    }

    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <body>
        <h2><?=$loginUsername?></h2><br>
        <h2><?=$loginPassword?></h2>
        <h2><?=print_r($user)?></h2>
        <h2></h2>
    </body>
</html>