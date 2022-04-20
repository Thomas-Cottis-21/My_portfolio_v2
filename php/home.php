<?php 
    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: /index.php");
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<script>console.log('Database connection successfull -> Access Granted')</script>";

        $stmt = $conn->prepare('SELECT * FROM clients');

        $stmt->execute();

        $clientInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $error) {
        echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";
        echo "<script>console.log('Database connection failed -> Access Denied')</script>";
    }

    $conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div>
        <h2>Welcome, <?=$_SESSION["name"]?>!</h2>
        <p>I am so glad that you were able to get through that, while still managing to learn so many great things! You'll be able to apply this very well!</p>
    </div>
    <div>
        <h3>We'll, we have a lot of work to do <?=$_SESSION["name"]?>!</h3>
    </div>
    <div>
        <?php 
            foreach ($clientInfo as $arrayLarge) {
                foreach ($arrayLarge as $arraySmall) {
                    echo "<p>$arraySmall</p>";
                }
            }
        ?>
    </div>
    <div>
    <!-- <p><?=$clientInfo[1]["clientId"] . " " . $clientInfo[1]["first_name"] . " " . $clientInfo[1]["last_name"] . " " . $clientInfo[1]["email"] . " " . $clientInfo[1]["number"] . " " . $clientInfo[1]["message"] . " " . $clientInfo[1]["date"]?></p> -->
    </div>
</body>
</html>