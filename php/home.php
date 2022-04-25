<?php 
    session_start();

    if (!isset($_SESSION["loggedin"])) {
        header("Location: /index.php");
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "my_portfolio_v2_test";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "<script>console.log('Database connection successfull -> Access Granted')</script>";

        $stmt = $conn->prepare('SELECT * FROM new_clients');
        $stmt->execute();

        $stmt2 = $conn->prepare('SELECT * FROM active_clients');
        $stmt2->execute();

        $stmt3 = $conn->prepare('SELECT * FROM former_clients');
        $stmt3->execute();

        /* new clients table */
        $stmt->bindColumn('clientId', $clientId);
        $stmt->bindColumn('first_name', $clientFirstName);
        $stmt->bindColumn('last_name', $clientLastName);
        $stmt->bindColumn('number', $clientNumber);
        $stmt->bindColumn('email', $clientEmail);
        $stmt->bindColumn('contact', $clientContactMethod);
        $stmt->bindColumn('message', $clientMessage);
        $stmt->bindColumn('date', $clientDate);

        /* active clinets table */
        $stmt2->bindColumn('clientId', $clientId);
        $stmt2->bindColumn('first_name', $clientFirstName);
        $stmt2->bindColumn('last_name', $clientLastName);
        $stmt2->bindColumn('number', $clientNumber);
        $stmt2->bindColumn('email', $clientEmail);
        $stmt2->bindColumn('contact', $clientContactMethod);
        $stmt2->bindColumn('message', $clientMessage);
        $stmt2->bindColumn('date', $clientDate);

        /* former clients table */
        $stmt3->bindColumn('clientId', $clientFirstName);
        $stmt3->bindColumn('last_name', $clientLastName);
        $stmt3->bindColumn('number', $clientNumber);
        $stmt3->bindColumn('email', $clientEmail);
        $stmt3->bindColumn('contact', $clientContactMethod);
        $stmt3->bindColumn('message', $clientMessage);
        $stmt3->bindColumn('date', $clientDate);

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
    <!-- -------------------- Back To Top -------------------- -->
    <div>
        <a href="#" id="backToTop" class="return-to-top-button bi bi-arrow-up background-color"></a>
    </div>

    <!-- -------------------- Dark Mode -------------------- -->
    <button id="toggleDm" class="buttonDm bi bi-lamp"></button>

    <header class="fixed-top header-transparent">
        <nav class="navbar navbar-expand-lg navLight">
            <a href="#" class="navbar-brand"><?=$_SESSION["name"]?></a>
            <button class="navbar-toggler" type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"><i class="bi bi-arrow-down-up"></i></span>
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
                    <div class="dropdown btn-group">
                        <p class="nav-link dropdown-toggle color" type="button"
                        data-bs-toggle="dropdown">Preferences</p>

                        <ul class="dropdown-menu navLight" id="dropdownMenu">
                            <li><button class="preferences-color-button green" id="green">Green</button></li>
                            <li><button class="preferences-color-button orange" id="orange">Orange</button></li>
                            <li><button class="preferences-color-button red" id="red">Red</button></li>
                            <li><button class="preferences-color-button light-blue" id="light-blue">Light Blue</button></li>
                            <li><button class="preferences-color-button dark-blue" id="dark-blue">Dark Blue</button></li>
                            <li><button class="preferences-color-button gray" id="gray">Gray</button></li>
                            <li><button class="preferences-color-button pink" id="pink">Pink</button></li>
                        </ul>
                    </div>
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
                    <div class="carousel-item active" data-bs-interval="5000" style="background-image: url(/assets/img/home/hero/punch.jpg);">
                        <div class="carousel-container">
                            <div class="carousel-caption">
                                <div class="carousel-header animate__animated animate__fadeInDown">Be better every day!</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">Look at what you've created! Keep learning!</div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item"  data-bs-interval="5000" style="background-image: url(/assets/img/home/hero/snowy_mountain.jpg);">
                        <div class="carousel-container">
                            <div class="carousel-caption">
                                <div class="carousel-header animate__animated animate__fadeInDown">Be a problem solver!</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">It's perfectly normal to get stuck and have to look to others for help!</div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/assets/img/home/hero/italy.jpg);">
                        <div class="carousel-container">
                            <div class="carousel-caption">
                                <div class="carousel-header animate__animated animate__fadeInDown">Keep improving!</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">This is only the beginning of what you'll do for others</div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="welcome">
                <div class="header dialog">
                    <h2>Hey, <span class="color"><?=$_SESSION["name"]?></span>!</h2>
                    <h3>Let's see what your day looks like</h3>
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="agenda">
                <!-- weather api -->

                <!-- clock -->
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="new-clients">
                <div class="header dialog">
                    <h3>New Clients</h3>
                    <hr>
                </div>
                <div class="card-container">
                    <?php 
                        while ($stmt->fetch(PDO::FETCH_BOUND)) {
                            echo "
                                <div class='client-card '>
                                    <div class='client-card-body'>
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
                                        <div class='button-container'>
                                            <button class='btn btn-default btn-pass'>Pass to active</button>
                                            <button class='btn btn-default btn-message'>Message</button>
                                            <button class='btn btn-default btn-delete'>Delete Client</button>
                                        </div>
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
                <div class="header dialog">
                    <h3>Active clients</h3>
                    <hr>
                </div>
                <div class="card-container">
                    <?php 
                        while ($stmt2->fetch(PDO::FETCH_BOUND)) {
                            echo "
                                <div class='client-card'>
                                    <div class='client-card-body'>
                                        <div class='client-info'>
                                            <div class='client-names'>
                                                <h4>$clientFirstName</h4>
                                                <h5>$clientLastName</h5>
                                            </div>
                                            <div class='client-contact-info'>
                                                <h5>$clientEmail</h5>
                                                <h6>$clientNumber</h6>
                                                <h6>$clientDate</h6>
                                            </div>
                                        </div>
                                        <div class='clients-contact-method'>$clientContactMethod</div>
                                        <div>$clientMessage</div>
                                        <div class='button-container'>
                                            <button class='btn btn-default btn-pass'>Pass to active</button>
                                            <button class='btn btn-default btn-message'>Message</button>
                                            <button class='btn btn-default btn-notes'>Client Notes</button>
                                            <button class='btn btn-default btn-delete'>Delete Client</button>
                                        </div>
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
            <div class="former-clients">
                <div class="header dialog">
                    <h3>Former Clients</h3>
                    <hr>
                </div>
                <div class="card-container">
                    <?php 
                        while ($stmt3->fetch(PDO::FETCH_BOUND)) {
                            echo "
                                <div class='client-card'>
                                    <div class='client-card-body'>
                                        <div class='client-info'>
                                            <div class='client-names'>
                                                <h4>$clientFirstName</h4>
                                                <h5>$clientLastName</h5>
                                            </div>
                                            <div class='client-contact-info'>
                                                <h5>$clientEmail</h5>
                                                <h6>$clientNumber</h6>
                                                <h6>$clientDate</h6>
                                            </div>
                                        </div>
                                        <div class='clients-contact-method'>$clientContactMethod</div>
                                        <div>$clientMessage</div>
                                        <div class='button-container'>
                                            <button class='btn btn-default btn-pass'>Pass to active</button>
                                            <button class='btn btn-default btn-message'>Message</button>
                                            <button class='btn btn-default btn-notes'>Client Notes</button>
                                            <button class='btn btn-default btn-delete'>Delete Client</button>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- -------------------- Custom js -------------------- -->
    <script src="/js/main.js"></script>

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</body>
</html>