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

        $stmt = $conn->prepare('SELECT * FROM new_clients');
        $stmt->execute();

        $stmt2 = $conn->prepare('SELECT * FROM active_clients');
        $stmt2->execute();

        $stmt->bindColumn('clientId', $clientId);
        $stmt->bindColumn('first_name', $clientFirstName);
        $stmt->bindColumn('last_name', $clientLastName);
        $stmt->bindColumn('number', $clientNumber);
        $stmt->bindColumn('email', $clientEmail);
        $stmt->bindColumn('contact', $clientContactMethod);
        $stmt->bindColumn('message', $clientMessage);
        $stmt->bindColumn('date', $clientDate);

        $stmt2->bindColumn('clientId', $clientId);
        $stmt2->bindColumn('first_name', $clientFirstName);
        $stmt2->bindColumn('last_name', $clientLastName);
        $stmt2->bindColumn('number', $clientNumber);
        $stmt2->bindColumn('email', $clientEmail);
        $stmt2->bindColumn('contact', $clientContactMethod);
        $stmt2->bindColumn('message', $clientMessage);
        $stmt2->bindColumn('date', $clientDate);

        /* var_dump($client); */


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
    <header class="fixed-top header-transparent">
        <nav class="navbar navbar-expand-lg navLight">
            <a href="#" class="navbar-brand"><?=$_SESSION["name"]?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a href="#" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">New Clients</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Current Clients</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">Old Clients</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">All Clients</a>
                    </li>
                </ul>
                <div class="login-nav-container">
                    <li class="nav-item"><button><p>Log out</p></button></li>
                </div>
            </div>
        </nav>
    </header>
    <section id="hero">
        <div class="container-fluid p-0 hero-container">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="background-image: url(/assets/img/hero/cave-man-hero.jpg);"></div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="welcome">
                <div class="header">
                    <h2>Welcome, <?=$_SESSION["name"]?>!</h2>
                    <hr>
                    <p>I am so glad that you were able to get through that, while still managing to learn so many great things! You'll be able to apply this very well! The following data are your clients and their needs! It is divided up between the different classes of clients and even their specific needs, defined by you!</p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="agenda">
                <div class="header">
                    <h3>You need to get to work, <?=$_SESSION["name"]?>!</h3>
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
                    <?php 
                        while ($stmt->fetch(PDO::FETCH_BOUND)) {
                            echo "
                                <div class='new-client-card '>
                                    <div class='new-client-card-body'>
                                        <div class='client-info'>
                                            <div class='client-names'>
                                                <h3>$clientFirstName</h5>
                                                <h4>$clientLastName</h4>
                                            </div>
                                            <div class='client-contact-info'>
                                                <h5>$clientEmail</h5>
                                                <h6>$clientNumber</h6>
                                                <h6>$clientDate</h6>
                                            </div>
                                        </div>
                                        <h6 class='client-contact-method'>$clientContactMethod</h6>
                                        <p class='card-text'>$clientMessage</p>
                                        <p></p>
                                        <button class='btn btn-default btn-pass'>Pass to active</button>
                                        <button class='btn btn-default btn-message'>Message</button>
                                        <button class='btn btn-default btn-delete'>Delete Client</button>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="active-clients">
                <div class="header">
                    <h3>Active clients</h3>
                    <hr>
                    <p>These are the clients that are active, meaning that they are activley messaging you, have purchased a service or you are doing some kind of work for them</p>
                </div>
                <div class="card-container">
                    <?php 
                        while ($stmt2->fetch(PDO::FETCH_BOUND)) {
                            echo "
                                <div class='card'>
                                    <div class='card-body'>
                                        <div class='client-info'>
                                            <div class='client-names'>
                                                <h4>$clientFirstName</h4>
                                                <h5>$clientLastName</h5>
                                            </div>
                                            <div class='client-contact-info'>
                                                <h4>$clientEmail</h4>
                                                <h5>$clientNumber</h5>
                                                <h5>$clientDate</h5>
                                            </div>
                                        </div>
                                        <div class='clients-contact-method'>$clientContactMethod</div>
                                        <div>$clientMessage</div>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Javascript-->

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- -------------------- Custom js -------------------- -->
    <script src="/js/main.js"></script>

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>