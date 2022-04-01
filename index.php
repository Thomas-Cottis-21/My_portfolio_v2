<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    $firstName = $lastName = $number = $email = $contact = $content = "";

    $fNameErr = $fNameFormatErr = $emailErr = $emailFormatErr = $contentErr = $contactErr = "";

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
        //$contact = data_filter($_POST["contact"]);
        $content = data_filter($_POST["content"]);


        if (empty($_POST["fname"])) {
            $fNameErr = "* First or business name is required";
            $formErr = TRUE;
        } else {
            $firstName = data_filter($_POST["fname"]);

            if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) {
                $fNameFormatErr = "Only letters and white space please";
                $formErr = TRUE;
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
            $formErr = TRUE;
        } else {
            $email = data_filter($_POST["email"]);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailFormatErr = "Invalid email format";
                $formErr = TRUE;
            }
        }
        /*
        if (empty($_POST["contact"])) {
            $contactErr = "* Prefered method of contact is required";
            $formErr = TRUE;
        } else {
            $contact = data_filter($_POST["contact"]);
        }
        */
        if (empty($_POST["Message"])) {
            $contentErr = "* A general message is required (Say Hi!)";
            $formErr = TRUE;
        } else {
            $content = data_filter($_POST["content"]);
        }
    }

    if (($_SERVER["REQUEST_METHOD"] == "POST") && (!($formErr))) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        //$databasename = "test";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=test", $username, $password);

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO Clients (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":firstname", $firstName, PDO::PARAM_STR);
            $stmt->bindParam(":lastname", $lastName, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $_SESSION["message"] = "<p>Your form was successfully submitted.</p>";

            $_SESSION["complete"] = true;

            header("Location: " . $_SERVER["REQUEST-URI"]);
            return;

        } catch(PDOException $error) {
            $_SESSION["message"] = "<p>We apologize, the form was not submitted successfully. Please try again at a later time.</p>";

            echo "<script>console.log('DB Error: " . addslashes($error->getMessage()) . "')</script>";
            
            $_SESSION["complete"] = true;

            header("Location: " . $_SERVER["REQUEST_URI"]);
            return;

            $conn = null;
        }
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
    

    <!-- -------------------- Bootstrap CDN link -------------------- -->
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
                <h1 class="display-5 intro-header-main color">Lorem ipsum dolor sit amet</h1>
                <p class="intro-content">Nulla dui tellus, blandit sed ipsum sed, pellentesque pretium ante. Pellentesque ut lectus eros. Donec cursus, felis ut luctus fermentum, nibh magna condimentum nulla, in fringilla nunc lacus sit amet tortor.</p>
                <hr> 
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color">fact1</div>
                        <p class="intro-content">Vivamus ultricies ipsum mauris, vestibulum iaculis quam viverra ut. Nullam posuere leo a lectus iaculis, venenatis mollis eros mollis.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color">fact2</div>
                        <p class="intro-content">Curabitur ac risus lacinia, sollicitudin ante et, dignissim velit. Quisque id odio nibh. Aenean magna est, feugiat eu faucibus a, rhoncus sit amet nisl.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color">fact3</div>
                        <p class="intro-content">Quisque lobortis, ex nec venenatis porta, nisl magna pellentesque quam, non mollis neque dolor in magna. Nunc vitae vestibulum odio, non congue ex. Cras pretium mauris non odio laoreet, ac egestas velit scelerisque.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color">fact4</div>
                        <p class="intro-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales. Pellentesque maximus tempus purus, sed rhoncus est tincidunt sed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Intro Section -------------------- -->

    <!-- -------------------- Skills Section -------------------- -->
    <div class="container" id="skills">
        <div class="display-3 d-flex mt-5 justify-content-center soft-skills-header-main color">Soft Skills</div>
        <div class="row">
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set one</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set two</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set three</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set four</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set five</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content color">skill set six</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
            </div>
        </div>
    <!-- -------------------- End Soft Skills Section -------------------- -->

    <!-- -------------------- Hard Skills Section -------------------- -->
    <div class="container" id="skills2">
        <div class="display-3 d-flex mt-5 justify-content-center hard-skills-header-main color">Hard Skills</div>
        <p class="mt-4 text-center hard-skills-content">Fusce dui eros, semper ac rutrum et, tempus sed velit. Mauris a interdum nisi. Fusce ornare urna pretium nulla gravida porttitor. Ut et est ut lectus venenatis cursus vel vitae leo. Donec mattis purus eu dignissim luctus. Phasellus quis quam et felis fringilla egestas ac nec leo. Nam lobortis ipsum id nisi mollis, eu viverra felis pharetra.</p>
    </div>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">HTML</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">CSS</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">Bootstrap</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">JavaScript</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">PHP</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge color">MySQL</div>
                <p>//This is where the wheel goes</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Hard Skills Section -------------------- -->

    <!-- -------------------- Education Section -------------------- -->
    <div class="container" id="education">
        <div class="display-3 d-flex mt-5 justify-content-center education-header-main color">Education</div>
        <p class="mt-4 text-center education-content-main">Phasellus quis finibus lectus. Vivamus ultricies, mi nec finibus sagittis, felis ex blandit ante, quis tincidunt augue leo id ex. Donec ultricies est lacus, consequat faucibus nulla scelerisque in. Integer non vestibulum mi. Mauris fringilla velit eu metus elementum, non varius nulla interdum. In hac habitasse platea dictumst. Nulla sit amet arcu sem. In et facilisis turpis. Aliquam non efficitur magna. Aenean massa magna, maximus sit amet luctus ut, malesuada ac augue.</p>
        <div class="row row-col-2 text-center">
            <div class="col-xl col-xs education-content-right">
                <div class="display-6 education-header-content color">Alta High School</div>
                <hr>
                <p>//Education descriptions</p>
            </div>
            <div class="col-xl col-xs education-content-left">
                <div class="display-6 education-header-content color">Salt Lake Community College</div>
                <hr>
                <p>//Education descriptions</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Education Section -------------------- -->

    <!-- -------------------- Projects Section -------------------- -->
    <div class="container-fluid" id="projects">
        <div class="display-3 d-flex mt-5 justify-content-center project-header-main color">Projects</div>
        <div class="row row-cols-1 d-flex justify-content-center text-center">
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="firstPort">My First Portfolio</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://google.com/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="polygraph">Grandpas' Polygraph Business</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://projectpolygraph.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="flute">Friends' flute instructor freelance</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://shaloraflute.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="cerakote">Cerakote business startup</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://joshcerakote.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Projects Section -------------------- -->

    <!-- -------------------- Contact Section -------------------- -->
    <section id="contact">
        <div class="display-3 d-flex mt-5 justify-content-center contact-header-main color">Contact</div>
        <div id="contactForm" class="container">
            <form id="myForm" action="<?= $_SERVER["PHP_SELF"]; ?>" method="POST">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <label for="first-name"></label>
                        <input class="border-color" type="text" id="fname" name="fname" value="<?= $firstName ?>" placeholder="First name">
                        <span class="error"><?= $fNameErr ?></span>
                        <span class="error"><?= $fNameFormatErr ?></span>
                    </div>

                    <div class="col-lg-6">
                        <label for="last-name"></label>
                        <input class="border-color" type="text" id="lname" name="lname" value="<?= $lastName ?>" placeholder="Last name">
                    </div>

                    <div class="col-lg-2">
                        <label for="number"></label>
                        <input class="border-color" type="text" id="number" name="number" value="<?= $number ?>" placeholder="Number">
                    </div>

                    <div class="col-lg-6">
                        <label for="email"></label>
                        <input class="border-color" type="email" id="email" name="email" value="<?= $email ?>" placeholder="Email">
                        <span class="error"><?= $emailErr ?></span>
                        <span class="error"><?= $emailFormatErr ?></span>
                    </div>
                    <div class="contact-checkbox-section mt-4">
                        <div>What is your prefered method of contact?</div>
                        <span class="error"><?= $contactErr ?></span>
                        <div class="contact-checkboxes d-flex mt-4">
                            <div class="col-lg-2">
                                <label for="contact">Text message</label>
                                <input type="checkbox" name="contact[]">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact">Phone call</label>
                                <input type="checkbox" name="contact[]">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact">Email</label>
                                <input type="checkbox" name="contact[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label for="content"></label>
                        <textarea class="border-color" name="content" id="content" value="<?= $content ?>" placeholder="Message"></textarea>
                        <span class="error"><?= $contentErr ?></span>
                    </div>
                    <button id="submit" class="contact-button-submit mt-3 col-lg-2 background-color mb-5" type="submit">Send</button>
                </div>
            </form>
        </div>
    </section>
    <div id="thanksModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times</button>
                    <h4 class="modal-title">Modal header</h4>
                </div>
                <div class="modal-body">
                    <p>This is the modal body</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
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