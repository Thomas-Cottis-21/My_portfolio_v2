<?php 
/* phpinfo(); */
//starts a new session if one isn't yet started
    if (!isset($_SESSION)) {
        session_start();
    }
//naming variabeles to ""

//naming session variables to avoid errors
if (!isset($_SESSION["loginFail"])) {
    $_SESSION["loginFail"] = null;
}

if (!isset($_SESSION["complete"])) {
    $_SESSION["complete"] = null;
}

//form variables
    $firstName = $lastName = $number = $email = $content = "";

//form error variables
    $fNameErr = $fNameFormatErr = $lNameFormatErr = $emailErr = $emailFormatErr = $contactErr = $contentErr = $numberErr = $captchaErr = "";

    $formErr = FALSE;

//cleaning and validating input data to avoid attacks
    function data_filter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validateMobile($mobile) {
        return preg_match('/^\D+$/', $mobile);
    }

//passing the cleaned input data to variables if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = data_filter($_POST["fname"]);
        $lastName = data_filter($_POST["lname"]);
        $number = data_filter($_POST["number"]);
        $email = data_filter($_POST["email"]);
        $content = data_filter($_POST["content"]);
    
//if statements to control error messages if user doesnt fill entire form or if form error is thrown

//first name error handling
        if (empty($_POST["fname"])) {
            $fNameErr = "* First or business name is required";
            $formErr = TRUE;
        } else if (!preg_match("/^[a-zA-Z-.()\'\"$%&*;:,=+-?@#!áéíóúÁÉÍÓÚÜüöÖ' ]*$/", $firstName)) {
            $fNameFormatErr = "* No special characters permited";
            $formErr = TRUE;
        } else {
            $fNameErr = null;
            $firstName;
        }

//last name not required, but only allows letters and spaces
        if (!preg_match("/^[a-zA-Z-.()\'\"$%&*;:,=+-?@#!áéíóúÁÉÍÓÚÜüöÖ' ]*$/", $lastName)) {
            $lNameFormatErr = "* No special characters";
            $formErr = TRUE;
        }

//calling validation of number input
        if (validateMobile($number)){
            $numberErr = "* Please use only numbers";
            $formErr = TRUE;
        }

//email error handling
        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
            $formErr = TRUE;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailFormatErr = "* Invalid email format";
            $formErr = TRUE;
        } else {
            $emailErr = null;
            $email;
        }

//contact error handling
        if (empty($_POST["contact"])) {
            $contactErr = "* Prefered method of contact is required";
            $formErr = TRUE;
        } else {
            $contactErr = null;
            $contact = $_POST["contact"];
            $contactStr = implode(", ", $contact);
        }

//textarea error handling
        if (empty($_POST["content"])) {
            $contentErr = "* A general message is required (Say Hi!)";
            $formErr = TRUE;
        } else if ((!preg_match("/^[a-zA-Z-.()\'\"$%&*;:,=+-?@#!áéíóúÁÉÍÓÚÜüöÖ' ]*$/", $content))) {
            $contentErr = "* No special characters permited";
            $formErr = TRUE;
        } else {
            $contentErr = null;
        }

//google captcha verification
        $post_data = http_build_query(
            array(
            //live server secret key
                'secret' => "6LdE_OEfAAAAALPLYkoqrOHVNOthK253LIq5o9Hy",

            //localhost secret key
                /* 'secret' => "6LeeBeIfAAAAAI3oCddDOiJweSySgZDBDoRoMZQR", */

                'response' => $_POST['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context  = stream_context_create($opts);
        $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', true, $context);
        $result = json_decode($response);

        if (empty($result->success)) {
            $formErr = TRUE;
            $captchaErr = "*Please verify that you are a human";
        }
    } 

//attempts to connect to the server when the user submits the entire form with no errors
    if (($_SERVER["REQUEST_METHOD"] == "POST") && ($formErr !== TRUE) || ($formErr = FALSE)) {
        require "./php/databaseConnection.php";

//try catch statemnet to either connect to the database and proceed with success modal, or procceed with the error modal
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

//retrieving error
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
//prepared statement that first binds php variables to mysql variables, then sends information to database
            $stmt = $conn->prepare("INSERT INTO clients (first_name, last_name, number, email, contact, message) VALUES (:firstname, :lastname, :number, :email, :contact, :message)");
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contact', $contactStr);
            $stmt->bindParam(':message', $content);

//excecuting the prepared statement
            $stmt->execute();

//session variables that show the modal messages. Need to be session variables in order to be accessed beyond page refresh
            $_SESSION["modalHeader"] = "Data Was Recieved Successfully";

            $_SESSION["modalMessage"] = 
            "<p class='color'>Thank you</p>
            <ul>
                <li>Thank you, <span class='color'>$firstName $lastName</span> for having interest in me and my experiences. I will get back to you within 24 hours.</li>
                <li>Your data has been recieved as follows:</li>
                <li class='color'> $email </li>
                <li class='color'> $number </li>
                <li>Your prefered contact methods: <span class='color'> $contactStr </span></li>
                <hr class='dialog'>
                <li>Your message: </li>
                <li class='color'> $content </li>
            </ul>";

//sets the session variable complete to true. The modal is triggered when this is set, and this is only set when the form is error free and submitted
            $_SESSION["complete"] = TRUE;

            //send mail upon submitting form with no errors

            $to = "tomcottis21@gmail.com";

            $subject = "New Response | $firstName $lastName!";

            $msg = wordwrap($msg, 70);

            $msg = nl2br($msg);

            $msg = $email . "\n" . $number . "\n" . $contactStr . "\n" . $content;

            $headers = "From: thomascottis@thomasandco.xyz";

            mail($to, $subject, $msg, $headers);

            //second email to the client

            $toClient = $email;

            $subjectClient = "Thank you from | Thomasandco";

            $msgClient = wordwrap($msg, 70);

            $msgClient = nl2br($msg);

            $msgClient = "Thank you, $firstName $lastName, for having a special interest in me and my endeavors to create aesthetic, functional websites and web applications for those who want to get thereselves out there with their ideas! Please allow me 24 hours in order to get back to you! \n Best regards - Thomas Joseph Cottis";

            $headersClient = "From: thomascottis@thomasandco.xyz";

            mail($toClient, $subjectClient, $msgClient, $headersClient);

        } catch(PDOException $error) {
//session variables with error message to be displayed in the modal
            $_SESSION["modalHeader"] = "Data was not recieved";

            $_SESSION["modalMessage"] = "<p>I'm sorry to let you know,<span class='color'> $firstName $lastName </span>that your data was not received. Please resubmit or try again later</p><p>I still thank you for your interest in me and my persuits. Please, if you are still unable to submit your form, contact me personally here and I will get back to you within 24 hours:</p><br><p class='color'><a class='color' href='tel:+13853352336'>385-335-2336</a></p><p><a class='color' href='mailto:tomcottis21@gmail.com'<br>tomcottis21@gmail.com</a></p>";

//echoing error message to the console instead of the user screen
            echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";

            $_SESSION["complete"] = TRUE;
        }

//killinng the connection
        $conn = null;
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="description" content="I can create you an effective website to help you on your way to success without breaking the bank.">
    <meta name="author" content="Thomas Joseph Cottis">
    <meta name="keywords" content="Local, Web developer, Web designer, cheap, good">
    <title>Thomas Cottis</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <!-- -------------------- Bootstrap icons CDN link -------------------- -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <!-- -------------------- Animate CDN link -------------------- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- -------------------- Custom CSS -------------------- -->
    <link rel="stylesheet" href="/assets/css/mystyle.css">

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- -------------------- Google fonts -------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&family=Oxygen:wght@300&family=Poppins:wght@200&family=Raleway:wght@200&family=Sora:wght@100&display=swap" rel="stylesheet">
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

            <button class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="bi bi-arrow-down-up"></i></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item text-nowwrap">
                        <a href="#softSkills" class="nav-link">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a href="#education" class="nav-link">Education</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown btn-group">
                            <p class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown">Projects</p>

                            <ul class="dropdown-menu navLight" id="dropdownMenu">
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
                    <li class="nav-item">
                        <a href="/assets/CV_web_dev_v3.pdf" class="nav-link" target="_blank">CV</a>
                    </li>
                    <li class="nav-item text-nowwrap">
                        <a href="https://github.com/Thomas-Cottis-21" target="_blank" class="nav-link">Github</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link">Contact</a>
                    </li>
                </ul>
                <div class="login-nav-container">
                    <li class="nav-item"><button type="button" class="access" data-bs-toggle="modal" data-bs-target="#user-access-modal"><p>Log in</p></button></li>
                </div>
            </div>
        </nav>
    </header>
    <div class="modal fade" id="user-access-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log in</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form name="loginForm" action="php/authenticate.php" method="POST" onsubmit="return authenticateForm()">
                    <span class="error"><?= $_SESSION["loginFail"]?></span>
                        <input type="text" class="border-color" id="username" name="username" placeholder="Username">
                        <div class="error" id="userErrorSpan"></div>

                        <input type="password" class="border-color" id="password" name="password" placeholder="Password">
                        <div class="error" id="passErrorSpan"></div>

                        <button type="submit" name="submitLogin" class="submit background-color">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default background-color" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php 
    //unsets the variable so that it doesn't keep triggering the modal on refresh
    function wipeLoginFail() {
        unset($_SESSION["loginFail"]);
    }

    //calls modal if the session variable loginFail is set to a message, then unsets for the next time the page is refreshed
    if (isset($_SESSION["loginFail"])) {
        echo "<script type='text/javascript'>$(document).ready(function() {
            setTimeout(function(){
                $('#user-access-modal').modal('show');
            }, 1000);
            });</script>";

        call_user_func("wipeLoginFail");
    }
    ?>
    <!-- -------------------- Hero Section -------------------- -->
    <section id="hero">
        <div class="container-fluid hero-container">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>

                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>

                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000" style="background-image: url(/assets/img/hero/clouds.jpg); background-position: center bottom">
                        <div class="carousel-container">
                            <div class="carousel-caption dark">
                                <div class="hero-content-container">
                                    <div class="carousel-header animate__animated animate__fadeInDown">I am an explorer</div>
                                    <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">I love to explore and discover new skills, like a new programming language, or a new real language!</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/assets/img/hero/buildings-bottom.jpg); background-position: center bottom">
                        <div class="carousel-container">
                            <div class="carousel-caption dark">
                                <div class="carousel-header animate__animated animate__fadeInDown">I am a problem solver</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">From software and hardware to welding up a new design, I love solving problems that come along with creating</div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/assets/img/hero/printer-hero.jpg); background-position: center top">
                        <div class="carousel-container">
                            <div class="carousel-caption">
                                <div class="carousel-header animate__animated animate__fadeInDown">I love to create</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">Designing and creating new and clever things has been a passion for me all my life</div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="5000" style="background-image: url(/assets/img/hero/fish.jpg); background-position: center top">
                        <div class="carousel-container">
                            <div class="carousel-caption">
                                <div class="carousel-header animate__animated animate__fadeInDown">I am inspired</div>
                                <div class="carousel-content animate__animated animate__fadeInUp animate__delay-1s">I love to see others designs and take inspiration so that I can learn and improve</div>
                            </div>
                        </div>
                    </div>
                </div> 
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>   
            </div>
        </div>
        <div id="about"></div>
    </section>
    <!-- -------------------- End Hero Section -------------------- -->

    <!-- -------------------- Intro Section -------------------- -->
    <div class="container d-flex">
        <div id="intro-container-row" class="row">
            <div class="col-6 intro-container-image">
                <img src="/assets/img/intro/Tom_img.jpeg" alt="Thomas and Johana Oxapampa" class="intro-image">
            </div>
            <div class="col col-right-intro">
                <h1 class="display-5 intro-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">I am truly passionate about a few things</h1>
                <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">I believe that once someone finds something that they are passionate about, they no longer worry about what they want to be when they grow up</p>
                <hr class="dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400"> 
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true">Programming</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">Although I am relativley new to the programming world, it has quickly become one of my greatest endeavors. I am decided on being a web developer because I find joy and satisfaction here.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="110">Design</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">I love to design and build furniture that lasts forever. I love to 3D-print new tools and machines. I love to create aesthetic things. Engineering and designing new things now enables me for a bright future.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="120">Hard work</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">I am passionate about working hard because I work hard at the things that I am passionate about. Not stopping until I've finished what I'm doing or found a solution, working hard is something that I believe in with my all.</p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="display-6 intro-header-content color" data-aos="fade-up" data-aos-duration="1000" data-aos-once="true" data-aos-delay="110">Learning</div>
                        <p class="intro-content dialog" data-aos="fade-up" data-aos-duration="1100" data-aos-once="true" data-aos-delay="100">I have many hobbies and skills. One of my greatest passions is learning new things. I love the idea of being able to apply myself in many different things in order to help those that I love and those that I don't know as well.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="softSkills"></div>
    <!-- -------------------- End Intro Section -------------------- -->

    <!-- -------------------- Skills Section -------------------- -->
    <div class="container">
        <div class="display-3 d-flex mt-5 justify-content-center soft-skills-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">My values | What do I stand for?</div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Solving problems</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">No matter the job, something is bound to go wrong. Problem solvers need to be there in real time to effectivley "put out the fires" that can arise in everyday scenarios in order to keep the cash flowing. I believe in being a problem solver, and in doing so also being a humble team player.</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Team work</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">There's nothing better than working on an unstoppable team that works together well. I am a team player because I help individuals work together in an efficient manner. Working on an efficient team is the best way to accomplish something greater than yourself.</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-right" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Efficiency</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-right" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">I truly dislike doing things over and over again. I believe that's why I love programming so much, because it's all about being efficient, with time and other resources. I've learned to be efficient with my time all my life, especially while serving a mission for The Church of Jesus Christ of Latter-Day Saints</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Creativity</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">My creative skills have flourished alongside my growing passions for aesthetics, like websites for unique people or something new in the 3D-printer. I love to use modern design and inspiration from others to improve my quality of life and that of others.</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Attention to detail</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">I really never knew how detailed I would have to be in order to program until I started to learn JavaScript. Every semicolin and bracket matters. Whatever it is that I have put myself to doing, it's always better to do it right the first time. I believe that being organized and humble helps me to do the work and pay close attention the details that matter.</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs mt-5">
                <div class="display-6 d-flex soft-skills-header-content color" data-aos="fade-up-left" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">Responsibility</div>
                <p class="mt-4 soft-skills-content dialog" data-aos="fade-up-left" data-aos-duration="1600" data-aos-once="true" data-aos-delay="400">I believe in being responsible and honest for my own actions, good or poor. It is only in that way that I can improve and move on, while not slowing down the rest of the team there to make money. To me, this is one of the greatest and most effective skills that I posess</p>
            </div>
        </div>
    </div> 
    <div id="hardSkills"></div>   
    <!-- -------------------- End Soft Skills Section -------------------- -->

    <!-- -------------------- Hard Skills Section -------------------- -->
    <section id="hard-skills">
        <div class="container">
            <div class="display-3 d-flex mt-5 justify-content-center hard-skills-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Hard Skills | What can I do?</div>
            <p class="mt-4 text-center hard-skills-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">My main study is Web Development, so that is what I have based my hard skills on. It is excatly what I am passionate about, creating something beautiful as well as funcional. These are my skills and what I peronally rank myself as, with the help of some peers to give a second opinion.</p>
        </div>
        <!-- beginning of progress bars -->

        <!-- Web Dev hard skills -->

        <div class="container-fluid">
            <div class="row text-center">
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">HTML</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 95%" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">95%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">CSS</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 90%" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">90%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Bootstrap</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 80%" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">80%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">JavaScript</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 85%" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">85%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">PHP</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 78%" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">78%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">MySQL</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 70%" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">70%</span>
                </div>
            </div>
            <!-- <hr class="dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400"> -->

            <!-- General Hard Skills -->

            <div class="row text-center">
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Spanish</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">100%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Github</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 82%" role="progressbar" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">82%</span>
                </div>
                <!-- <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge color" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Mechanics</div>
                    <div class="progress">
                        <div class="progress-bar background-color" style="width: 95%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog">95%</span>
                </div> -->
            </div>
            <hr class="dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">

            <!-- Goals -->
            <div class="container" id="goals">
                <h3 class="goals-header" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="300">My Goals for 2022</h3>
                <p class="mt-4 text-center hard-skills-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">My goals are to learn React.js as well as Python and to start to implement them into sites and projects that I already manage + create new user interfaces for clients that I am working with currently.</p>
                <p class="mt-4 text-center hard-skills-content dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">The following displays how far I am along in learning and implementing React.js and Python into my workflow and so far, I love it!</p>
            </div>

            <div class="row text-center d-flex justify-content-md-around">
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge goals-sub-header" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">React.js</div>
                    <div class="progress">
                        <div class="progress-bar goal-progress" style="width: 75%" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">75%</span>
                </div>
                <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge goals-sub-header" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Python</div>
                    <div class="progress">
                        <div class="progress-bar goal-progress" style="width: 60%" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">60%</span>
                </div>
                <!-- <div class="col-lg-4 col-md-6 col-xs hard-skills-card-container">
                    <div class="display-6 hard-skills-header-gauge goals-sub-header" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">App Development</div>
                    <div class="progress">
                        <div class="progress-bar goal-progress" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" data-aos="zoom-in" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"></div>
                    </div>
                    <span class="dialog" data-aos="fade-up" data-aos-duration="1300" data-aos-once="true">75%</span>
                </div> -->
            </div>
        </div>
        <div id="education"></div>
    </section>
    <!-- -------------------- End Hard Skills Section -------------------- -->

    <!-- -------------------- Education Section -------------------- -->
    <div class="container">
        <div class="display-3 d-flex mt-5 justify-content-center education-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Education</div>
        <p class="mt-4 text-center education-content-main dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">I graduated from Alta High School in 2018. From there I left on a mission for The Church of Jesus Christ of Latter-Day Saints to Lima, Peru for 2 years where I learned Spanish. Upon returning, I entered the Web Design and Develpment program in SLCC to get me started. I am currently enrolled in the program.</p>
        <div class="row row-col-2 text-center">
            <div class="col-xl col-xs education-content-right">
                <div class="display-6 education-header-content color" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Alta High School</div>
                <hr class="dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">
                <p class="dialog" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">I attended to Alta High School from 2016 to 2018. I learned everything I needed to graduate, but I also took CTEC (Technical Education). That's where I learned how to weld, work on cars and to really use my head to create amazing things! Those experiences have kickstarted me to go on and keep creating amazing things and to even attend college!</p>
            </div>
            <div class="col-xl col-xs education-content-left">
                <div class="display-6 education-header-content color" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Salt Lake Community College</div>
                <hr class="dialog" data-aos="fade-up" data-aos-duration="1500" data-aos-once="true" data-aos-delay="400">
                <p class="dialog" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">I have graduated the web development course from Salt Lake Community College, earning an A+! I am currently freelancing, working with lots of clients for cheap in order to gain as much experience as possible and I really love what I do. I am currently working on finishing my associates degree and planning to go on to get a Bachelors Degree in Computer / Data science.</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Education Section -------------------- -->

    <!-- -------------------- Projects Section -------------------- -->
    <div class="container-fluid" id="projects">
        <div class="display-3 d-flex mt-5 justify-content-center project-header-main color" id="polygraph" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Projects</div>
        <div class="row row-cols-1 d-flex justify-content-center text-center">
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Grandpas' Polygraph Business</div>
                    <p class="mb-2 dialog project-content" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">My grandfather, Joseph Cottis worked for the F.B.I as a lie detector. He was in need of a new, modern website in order to better connect him to the younger generations, as his old website was slowly being outdated. I made him this website without knowing if he would implement it to get more practice in. I used a bootstrap theme because there is no better way to learn than to jump in head first.</p>
                    <iframe class="project-iframe embed-responsive-item" src="https://projectpolygraph.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="flute" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Shaloras' flute instructor freelance</div>
                    <p class="mb-2 dialog project-content" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">I started telling my friends about my new career path and all the exciting progress that I was making. Eager to find more projects, my best friend's wife, Shalora presented me an idea for her. She wants to be a freelancing flute instructor, but doesn't know where to start. I am currently working with them in order to put new content out as well as building a new database to keep track of clients, appointment and class times.</p>
                    <iframe class="project-iframe embed-responsive-item" src="https://shaloraflute.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe color" id="cerakote" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Cerakote business startup</div>
                    <p class="mb-2 dialog project-content" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">My brother in-law, Josh is extremley creative and talented with many things, especially creative things like photography and painting. He is currently in the proccess of starting his own cerakote business and needs a powerful website to keep track of all of the data that is associated with an entire start-up as well as a creative and attractive front-end to keep the traffic coming</p>
                    <iframe class="project-iframe embed-responsive-item" src="https://joshcerakote.netlify.app/" frameborder="0" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="200"></iframe>
                </div>
            </div>
        </div>
        <div id="contact"></div>
    </div>
    <!-- -------------------- End Projects Section -------------------- -->

    <!-- -------------------- Contact Section -------------------- -->
    <div id="thanksModal" class="modal fade" tabindex="-1" aria-labelledby="thanksModalLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="thanksModalLabel"><?=$_SESSION["modalHeader"]?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?=$_SESSION["modalMessage"]?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default background-color" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <section>
        <div class="display-3 d-flex mt-5 justify-content-center contact-header-main color" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true">Contact</div>
        <div id="contactForm" class="container">
            <form id="myForm" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>#contact" method="POST">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <label for="first-name"></label>
                        <input class="border-color dialog" type="text" id="fname" name="fname" value="<?=$firstName?>" placeholder="First name" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?=$fNameErr?></span>
                        <span class="error"><?=$fNameFormatErr?></span>
                    </div>

                    <div class="col-lg-6">
                        <label for="last-name"></label>
                        <input class="border-color dialog" type="text" id="lname" name="lname" value="<?=$lastName?>" placeholder="Last name" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?=$lNameFormatErr?></span>
                    </div>

                    <div class="col-lg-2">
                        <label for="number"></label>
                        <input class="border-color dialog" type="text" id="number" name="number" value="<?=$number?>" placeholder="Number" data-aos="fade-left" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?= $numberErr ?></span>
                    </div>

                    <div class="col-lg-6">
                        <label for="email"></label>
                        <input class="border-color dialog" type="email" id="email" name="email" value="<?=$email?>" placeholder="Email" data-aos="fade-right" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">
                        <span class="error"><?=$emailErr?></span>
                        <span class="error"><?=$emailFormatErr?></span>
                    </div>
                    <div class="contact-checkbox-section mt-4">
                        <div class="dialog" data-aos="fade-down" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">What is your prefered method of contact?</div>
                        <span class="error"><?= $contactErr ?></span>
                        <div class="contact-checkboxes mt-4 row">
                            <div class="col-lg-2 col-md-5 col-xs-7">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Text message</label>
                                <input type="checkbox" name="contact[]" value="Text" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="400">
                            </div>

                            <div class="col-lg-2 col-md-12 col-xs-12">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Phone call</label>
                                <input type="checkbox" name="contact[]" value="Call" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="400">
                            </div>

                            <div class="col-lg-2 col-md-5 col-xs-7">
                                <label for="contact" class="dialog" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Email</label>
                                <input type="checkbox" name="contact[]" value="Email" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="500">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="content"></label>
                        <textarea class="border-color dialog" name="content" id="content" value="" placeholder="Message" data-aos="fade-up" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300"><?php if (isset($content)) echo $content ?></textarea>
                        <span class="error"><?= $contentErr ?></span>
                    </div>
                    <div class="form-submit">
                        <!-- live server site key -->
                            <div class="g-recaptcha" data-sitekey="6LdE_OEfAAAAAPaFd2BdyxjgequdsQSm8YoBxVdy"></div>
                        <!-- localhost server site key -->
                            <!-- <div class="g-recaptcha" data-sitekey="6LeeBeIfAAAAAEsRAoPESJZa4IZxG4dBwFCDLNcT"></div> -->
                        <span class="error"><?= $captchaErr ?></span>
                        <button id="submit" type="submit" class="contact-button-submit btn btn-default mt-3 col-lg-2 background-color mb-5" data-aos="zoom-in" data-aos-anchor-placement="bottom bottom" data-aos-duration="1400" data-aos-once="true" data-aos-delay="300">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <?php 
//whether or not the form data was sent, displays modal with error or success message
        if (isset($_SESSION["complete"])) {
            echo "<script>$(document).ready(function() {
                setTimeout(function(){
                    $('#thanksModal').modal('show');
                }, 3000);
            });</script>";
            
//unsets the current session since the form was submitted
            session_unset();
        }
    ?>
    <!-- -------------------- End Contact Section -------------------- -->

    <!-- -------------------- Bootstrap CDN -------------------- -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- -------------------- Custom js -------------------- -->
    <script src="/js/main.js"></script>

    <!-- -------------------- data-aos onscroll library -------------------- -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>
</body>
</html>