<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $firstName = $lastName = $number = $email = $content = "";

    $fNameErr = $fNameFormatErr = $emailErr = $emailFormatErr = $contactErr = $contentErr = "";

    $formErr = FALSE;

    function data_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = data_filter($_POST["fname"]);
        $lastName = data_filter($_POST["lname"]);
        $number = data_filter($_POST["number"]);
        $email = data_filter($_POST["email"]);

        if (!empty($_POST["contact"])) {
            $contact = ($_POST["contact"]);
        } else {
            $contact = null;
        }
        
        $content = data_filter($_POST["content"]);


        if (empty($_POST["fname"])) {
            $fNameErr = "* First or business name is required";
            $formErr = TRUE;
        } else {
            $firstName;

            if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
                $fNameFormatErr = "Only letters and white space please";
                $formErr = TRUE;
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
            $formErr = TRUE;
        } else {
            $email;
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailFormatErr = "Invalid email format";
                $formErr = TRUE;
            }
        }
        
        if (empty($_POST["contact"])) {
            $contactErr = "* Prefered method of contact is required";
            $formErr = TRUE;
        } else {
            $contact;
            $contactStr = implode(", ", $contact);
        }
        
        if (empty($_POST["content"])) {
            $contentErr = "* A general message is required (Say Hi!)";
            $formErr = TRUE;
        }
    }

    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($formErr !== TRUE)) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $conn->prepare("INSERT INTO clients (firstname, lastname, email, message, contact) VALUES (:firstname, :lastname, :email, :message, :contact)");
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $content);
            $stmt->bindParam(':contact', $contactStr);

            $stmt->execute();

            $modalHeader = "Data Recieved Successfully";

            $modalMessage = 
            "<p class='color'>Thank you</p>
            <ul>
                <li>Thank you, <span class='color'>$firstName $lastName</span> for having interest in me and my experiences. I will get back to you within 24 hours.</li>
                <li>Your data has been recieved as follows:</li>
                <li class='color'> $email </li>
                <li>Your prefered contact methods: <span class='color'> $contactStr </span></li>
                <hr>
                <li>Your message: </li>
                <li class='color'> $content </li>
            </ul>";

            $_SESSION["complete"] = true;

            
        } catch(PDOException $error) {
            $_SESSION["complete"] = true;
            echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";

            $modalHeader = "Data was not recieved";

            $modalMessage = "<p>I'm sorry to let you know, $firstName $lastName that your data was not received. Please resubmit or try again later</p><br><p>I still thank you for your interest in me and my persuits. Please, if you are still unable to submit your form, contact me personally here and I will get back to you within 24 hours:</p><br><p class='color'>385-335-2336<br>tomcottis21@gmail.com</p>";
        }

        $conn = null;
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="I can create you an effective money making machine to help you on your way to success without breaking the bank.">
    <meta name="author" content="Thomas Joseph Cottis">
    <meta name="keywords" content="Local, Web developer, Web designer, cheap, good">
    <title>Thomas Cottis Website Design & Development</title>
    
    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- -------------------- Bootstrap icons CDN link -------------------- -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- -------------------- Custom CSS -------------------- -->
    <link rel="stylesheet" href="/css/mystyle.css">

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- -------------------- Google fonts -------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300&family=Sora:wght@100&display=swap&family=Nunito:wght@200&display=swap&family=Raleway:wght@200&display=swap" rel="stylesheet">
</head>
<body>
    <div id="home"></div>
    <!-- -------------------- Back To Top -------------------- -->
    <div>
        <a href="#" id="backToTop" class="return-to-top-button bi bi-arrow-up background-color"></a>
    </div>

    <!-- -------------------- Dark Mode -------------------- -->
    <button id="toggleDm" class="buttonDm bi bi-lamp"></button>

    <!-- -------------------- Nav bar -------------------- -->
    <header class="fixed-top header-transparent">
        <nav class="navbar navbar-expand-lg navLight" id="navBar">
            <a href="#" class="navbar-brand">Thomas Joseph Cottis</a>

            <button class="navbar-toggler background-color" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
                <span class="bi bi-arrow-bar-down"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="#skills" class="nav-link">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a href="#skills2" class="nav-link">Skills 2</a>
                    </li>
                    <li class="nav-item">
                        <a href="#education" class="nav-link">Education</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown btn-group">
                            <p class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown">Projects</p>

                            <ul class="dropdown-menu navLight" id="dropdownMenu">
                                <li><a href="#firstPort" class="projects-dropdown-button">My First Portfolio</a></li>
                                <li><a href="#polygraph" class="projects-dropdown-button">Polygraph Business</a></li>
                                <li><a href="#flute" class="projects-dropdown-button">Flute Instructor</a></li>
                                <li><a href="#cerakote" class="projects-dropdown-button">Cerakote Business</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown btn-group">
                            <p class="nav-link dropdown-toggle color" type="button" data-bs-toggle="dropdown">Preferences</p>

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
                    </li>
                    <li class="nav-item active">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- -------------------- Hero Section -------------------- -->
<section id="hero">
    <div class="container-fluid p-0 hero-container">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000" style="background-image: url(/Img/hero/mountain-bike-hero.jpg);">
                    <div class="carousel-container">
                        <div class="carousel-caption">
                            <div class="carousel-header">Title for carousel 1</div>
                            <div class="carousel-content">Content for carousel 1</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/Img/hero/rock-climbing-rope-hero.jpg);">
                    <div class="carousel-container">
                        <div class="carousel-caption">
                            <div class="carousel-header">Title for carousel 1</div>
                            <div class="carousel-content">Content for carousel 1</div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/Img/hero/overlander-hero.jpg);">
                    <div class="carousel-container">
                        <div class="carousel-caption">
                            <div class="carousel-header">Title for carousel 1</div>
                            <div class="carousel-content">Content for carousel 1</div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>
    <!-- -------------------- End Hero Section -------------------- -->

    <!-- -------------------- Intro Section -------------------- -->
    <div class="container d-flex" id="about">
        <div id="intro-container-row" class="row">
            <div class="col-6 intro-container-image">
                <img src="/Img/intro/Tom_img.jpeg" alt="Thomas and Johana Oxapampa" class="intro-image">
            </div>
            <div class="col col-right-intro">
                <h1 class="display-5 intro-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Lorem ipsum dolor sit amet</h1>
                <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Nulla dui tellus, blandit sed ipsum sed, pellentesque pretium ante. Pellentesque ut lectus eros. Donec cursus, felis ut luctus fermentum, nibh magna condimentum nulla, in fringilla nunc lacus sit amet tortor.</p>
                <hr data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400"> 
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">fact1</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">Vivamus ultricies ipsum mauris, vestibulum iaculis quam viverra ut. Nullam posuere leo a lectus iaculis, venenatis mollis eros mollis.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="110">fact2</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">Curabitur ac risus lacinia, sollicitudin ante et, dignissim velit. Quisque id odio nibh. Aenean magna est, feugiat eu faucibus a, rhoncus sit amet nisl.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="120">fact3</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">Quisque lobortis, ex nec venenatis porta, nisl magna pellentesque quam, non mollis neque dolor in magna. Nunc vitae vestibulum odio, non congue ex. Cras pretium mauris non odio laoreet, ac egestas velit scelerisque.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="110">fact4</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales. Pellentesque maximus tempus purus, sed rhoncus est tincidunt sed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Intro Section -------------------- -->

    <!-- -------------------- Skills Section -------------------- -->
    <div class="container" id="skills">
        <div class="display-3 d-flex mt-5 justify-content-center soft-skills-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Soft Skills</div>
        <div class="row">
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set one</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set two</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set three</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set four</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set five</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">skill set six</div>
                    <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
            </div>
        </div>
    <!-- -------------------- End Soft Skills Section -------------------- -->

    <!-- -------------------- Hard Skills Section -------------------- -->
    <div class="container" id="skills2">
        <div class="display-3 d-flex mt-5 justify-content-center hard-skills-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Hard Skills</div>
        <p class="mt-4 text-center hard-skills-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Fusce dui eros, semper ac rutrum et, tempus sed velit. Mauris a interdum nisi. Fusce ornare urna pretium nulla gravida porttitor. Ut et est ut lectus venenatis cursus vel vitae leo. Donec mattis purus eu dignissim luctus. Phasellus quis quam et felis fringilla egestas ac nec leo. Nam lobortis ipsum id nisi mollis, eu viverra felis pharetra.</p>
    </div>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">HTML</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">CSS</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Bootstrap</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">JavaScript</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">PHP</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">MySQL</div>
                <p class="dialog">//This is where the wheel goes</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Hard Skills Section -------------------- -->

    <!-- -------------------- Education Section -------------------- -->
    <div class="container-fluid" id="education">
        <div class="display-3 d-flex mt-5 justify-content-center education-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Education</div>
        <p class="mt-4 text-center education-content-main dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Phasellus quis finibus lectus. Vivamus ultricies, mi nec finibus sagittis, felis ex blandit ante, quis tincidunt augue leo id ex. Donec ultricies est lacus, consequat faucibus nulla scelerisque in. Integer non vestibulum mi. Mauris fringilla velit eu metus elementum, non varius nulla interdum. In hac habitasse platea dictumst. Nulla sit amet arcu sem. In et facilisis turpis. Aliquam non efficitur magna. Aenean massa magna, maximus sit amet luctus ut, malesuada ac augue.</p>
        <div class="row row-col-2 text-center">
            <div class="col-xl col-xs education-content-right">
                <div class="display-6 education-header-content color" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Alta High School</div>
                <hr data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">
                <p class="dialog" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">//Education descriptions</p>
            </div>
            <div class="col-xl col-xs education-content-left">
                <div class="display-6 education-header-content color" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Salt Lake Community College</div>
                <hr data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">
                <p class="dialog" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">//Education descriptions</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Education Section -------------------- -->

    <!-- -------------------- Projects Section -------------------- -->
    <div class="container-fluid" id="projects">
        <div class="display-3 d-flex mt-5 justify-content-center project-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Projects</div>
        <div class="row row-cols-1 d-flex justify-content-center text-center">
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="firstPort" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">My First Portfolio</div>
                    <p class="mb-2 dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://google.com/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="polygraph" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Grandpas' Polygraph Business</div>
                    <p class="mb-2 dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://projectpolygraph.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="flute" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Friends' flute instructor freelance</div>
                    <p class="mb-2 dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://shaloraflute.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="cerakote" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Cerakote business startup</div>
                    <p class="mb-2 dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://joshcerakote.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Projects Section -------------------- -->

    <!-- -------------------- Contact Section -------------------- -->
    <section id="contact">
        <div class="display-3 d-flex mt-5 justify-content-center contact-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Contact</div>
        <div id="contactForm" class="container">
            <form id="myForm" action="" method="POST">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <label for="first-name"></label>
                        <input class="border-color dialog" type="text" id="fname" name="fname" value="<?= $firstName ?>" placeholder="First name" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?= $fNameErr ?></span>
                        <span class="error"><?= $fNameFormatErr ?></span>
                    </div>

                    <div class="col-lg-6">
                        <label for="last-name"></label>
                        <input class="border-color dialog" type="text" id="lname" name="lname" value="<?= $lastName ?>" placeholder="Last name" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                    </div>

                    <div class="col-lg-2">
                        <label for="number"></label>
                        <input class="border-color dialog" type="text" id="number" name="number" value="<?= $number ?>" placeholder="Number" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                    </div>

                    <div class="col-lg-6">
                        <label for="email"></label>
                        <input class="border-color dialog" type="email" id="email" name="email" value="<?= $email ?>" placeholder="Email" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?= $emailErr ?></span>
                        <span class="error"><?= $emailFormatErr ?></span>
                    </div>
                    <div class="contact-checkbox-section mt-4">
                        <div class="dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">What is your prefered method of contact?</div>
                        <span class="error"><?= $contactErr ?></span>
                        <div class="contact-checkboxes d-flex mt-4">
                            <div class="col-lg-2">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Text message</label>
                                <input type="checkbox" name="contact[]" value="Text" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="400">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Phone call</label>
                                <input type="checkbox" name="contact[]" value="Call" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="400">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Email</label>
                                <input type="checkbox" name="contact[]" value="Email" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label for="content"></label>
                        <textarea class="border-color dialog" name="content" id="content" value="" placeholder="Message" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"><?php if (isset($content)) echo $content ?></textarea>
                        <span class="error"><?= $contentErr ?></span>
                    </div>
                    <button id="submit" type="submit" data-bs-toggle="modal" data-bs-target="#thanksModal" class="contact-button-submit mt-3 col-lg-2 background-color mb-5" data-aos="zoom-in" data-aos-anchor-placement="bottom bottom" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Send</button>
                </div>
            </form>
        </div>
    </section>
    <div id="thanksModal" class="modal fade" tabindex="-1" aria-labelledby="thanksModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="thanksModalLabel"><?= $modalHeader ?></h4>
                </div>
                <div class="modal-body">
                    <?= $modalMessage ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php 
        if ($_SESSION["complete"]) {
            echo "<script>$(document).ready(function() {
                $('#thanksModal').modal('show');
            });</script>";
            session_unset();
        }
    ?>
    <!-- -------------------- End Contact Section -------------------- -->

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <!-- -------------------- Custom js -------------------- -->
    <script src="/js/main.js"></script>

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>
</body>
</html>