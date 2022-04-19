<?php 
    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: /index.php");
        exit;
    }
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
</body>
</html>