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

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- -------------------- Bootstrap icons CDN link -------------------- -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- -------------------- Animate CDN link -------------------- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- -------------------- Custom CSS -------------------- -->
    <link rel="stylesheet" href="/assets/css/home.css">

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- -------------------- Google fonts -------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300&family=Sora:wght@100&display=swap&family=Nunito:wght@200&display=swap&family=Raleway:wght@200&display=swap" rel="stylesheet">

</head>
<body>
    <section>
        <div class="container-fluid">
            <div class="welcome">
                <div class="header">
                    <h2>Welcome, <?=$_SESSION["name"]?>!</h2>
                    <hr>
                    <p>I am so glad that you were able to get through that, while still managing to learn so many great things! You'll be able to apply this very well!</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="agenda">
                <div class="header">
                    <h3>We'll, we have a lot of work to do <?=$_SESSION["name"]?>!</h3>
                    <p>Let's see who's new on the list</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="new-clients">
                <div class="header">
                    <h3>New Clients</h3>
                    <hr>
                    <p>These are your new clients that you still need to interact with!</p>
                </div>
                <div class="card-container">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Title</h5>
                            <h6 class="card-subtitle">Subtitle</h6>
                            <p class="card-text">card text in order to display data about client, who will have their own card of data</p>
                            <button class="btn btn-default">Make regular</button>
                            <button class="btn btn-default">Delete Client</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Title</h5>
                            <h6 class="card-subtitle">Subtitle</h6>
                            <p class="card-text">card text in order to display data about client, who will have their own card of data</p>
                            <button class="btn btn-default">Make regular</button>
                            <button class="btn btn-default">Delete Client</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Title</h5>
                            <h6 class="card-subtitle">Subtitle</h6>
                            <p class="card-text">card text in order to display data about client, who will have their own card of data</p>
                            <button class="btn btn-default">Make regular</button>
                            <button class="btn btn-default">Delete Client</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Title</h5>
                            <h6 class="card-subtitle">Subtitle</h6>
                            <p class="card-text">card text in order to display data about client, who will have their own card of data</p>
                            <button class="btn btn-default">Make regular</button>
                            <button class="btn btn-default">Delete Client</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div>
        <?php 
            foreach ($clientInfo as $arrayLarge) {
                foreach ($arrayLarge as $arraySmall) {
                    echo "<p>$arraySmall</p>";
                }
            }
        ?>
    </div>
    <!-- Javascript-->

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- -------------------- Custom js -------------------- -->
    <script src="/js/main.js"></script>

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>