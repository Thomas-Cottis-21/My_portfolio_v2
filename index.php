<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio V2</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300&family=Sora:wght@100&display=swap" rel="stylesheet">
</head>
<body>
    <!-- -------------------- Back To Top -------------------- -->
    <a href="#" id="backToTop" class="return-to-top-button bi bi-arrow-up"></a>
    
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
    <div class="container d-flex">
        <div id="intro-container-row" class="row">
            <div class="col-6 intro-container-image">
                <img src="/Img/intro/Tom_img.jpeg" alt="Thomas and Johana Oxapampa" class="intro-image">
            </div>
            <div class="col col-right-intro">
                <h1 class="display-5 intro-header-main">Lorem ipsum dolor sit amet</h1>
                <p class="intro-content">Nulla dui tellus, blandit sed ipsum sed, pellentesque pretium ante. Pellentesque ut lectus eros. Donec cursus, felis ut luctus fermentum, nibh magna condimentum nulla, in fringilla nunc lacus sit amet tortor.</p>
                <hr> 
                <div class="row row-cols-2">
                    <div class="col">
                        <div class="display-6 intro-header-content">fact1</div>
                        <p class="intro-content">Vivamus ultricies ipsum mauris, vestibulum iaculis quam viverra ut. Nullam posuere leo a lectus iaculis, venenatis mollis eros mollis.</p>
                    </div>
                    <div class="col">
                        <div class="display-6 intro-header-content">fact2</div>
                        <p class="intro-content">Curabitur ac risus lacinia, sollicitudin ante et, dignissim velit. Quisque id odio nibh. Aenean magna est, feugiat eu faucibus a, rhoncus sit amet nisl.</p>
                    </div>
                    <div class="col">
                        <div class="display-6 intro-header-content">fact3</div>
                        <p class="intro-content">Quisque lobortis, ex nec venenatis porta, nisl magna pellentesque quam, non mollis neque dolor in magna. Nunc vitae vestibulum odio, non congue ex. Cras pretium mauris non odio laoreet, ac egestas velit scelerisque.</p>
                    </div>
                    <div class="col">
                        <div class="display-6 intro-header-content">fact4</div>
                        <p class="intro-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales. Pellentesque maximus tempus purus, sed rhoncus est tincidunt sed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Intro Section -------------------- -->

    <!-- -------------------- Skills Section -------------------- -->
    <div class="container">
        <div class="display-3 d-flex mt-5 justify-content-center soft-skills-header-main">Soft Skills</div>
        <div class="row">
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set one</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set two</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set three</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set four</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set five</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-xs mt-5">
                    <div class="display-6 d-flex soft-skills-header-content">skill set six</div>
                    <p class="mt-4 soft-skills-content">Sed congue risus turpis, eu pellentesque neque iaculis sit amet. Donec faucibus mauris ac orci dictum rutrum. Nam vulputate sagittis ipsum ut sodales.</p>
                </div>
            </div>
        </div>
    <!-- -------------------- End Soft Skills Section -------------------- -->

    <!-- -------------------- Hard Skills Section -------------------- -->
    <div class="container">
        <div class="display-3 d-flex mt-5 justify-content-center hard-skills-header-main">Hard Skills</div>
        <p class="mt-4 text-center hard-skills-content">Fusce dui eros, semper ac rutrum et, tempus sed velit. Mauris a interdum nisi. Fusce ornare urna pretium nulla gravida porttitor. Ut et est ut lectus venenatis cursus vel vitae leo. Donec mattis purus eu dignissim luctus. Phasellus quis quam et felis fringilla egestas ac nec leo. Nam lobortis ipsum id nisi mollis, eu viverra felis pharetra.</p>
    </div>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">HTML</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">CSS</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">Bootstrap</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">JavaScript</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">PHP</div>
                <p>//This is where the wheel goes</p>
            </div>
            <div class="col-lg-4 col-md-6 col-xs">
                <div class="display-6 hard-skills-header-gauge">MySQL</div>
                <p>//This is where the wheel goes</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Hard Skills Section -------------------- -->

    <!-- -------------------- Education Section -------------------- -->
    <div class="container">
        <div class="display-3 d-flex mt-5 justify-content-center education-header-main">Education</div>
        <p class="mt-4 text-center education-content-main">Phasellus quis finibus lectus. Vivamus ultricies, mi nec finibus sagittis, felis ex blandit ante, quis tincidunt augue leo id ex. Donec ultricies est lacus, consequat faucibus nulla scelerisque in. Integer non vestibulum mi. Mauris fringilla velit eu metus elementum, non varius nulla interdum. In hac habitasse platea dictumst. Nulla sit amet arcu sem. In et facilisis turpis. Aliquam non efficitur magna. Aenean massa magna, maximus sit amet luctus ut, malesuada ac augue.</p>
        <div class="row row-col-2 text-center">
            <div class="col-xl col-xs education-content-right">
                <div class="display-6 education-header-content">Alta High School</div>
                <hr>
                <p>//Education descriptions</p>
            </div>
            <div class="col-xl col-xs education-content-left">
                <div class="display-6 education-header-content">Salt Lake Community College</div>
                <hr>
                <p>//Education descriptions</p>
            </div>
        </div>
    </div>
    <!-- -------------------- End Education Section -------------------- -->

    <!-- -------------------- Projects Section -------------------- -->
    <div class="container-fluid">
        <div class="display-3 d-flex mt-5 justify-content-center project-header-main">Projects</div>
        <div class="row row-cols-1 d-flex justify-content-center text-center">
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe">My First Portfolio</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://google.com/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe">Grandpas' Polygraph Business</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://projectpolygraph.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe">Friends' flute instructor freelance</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://shaloraflute.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
            <div class="col">
                <div class="embed-responsive">
                    <div class="display-6 mt-5 project-header-iframe">Cerakote business startup</div>
                    <p class="mb-2">//This is where the description for the iframes will go</p>
                    <iframe class="project-iframe" src="https://joshcerakote.netlify.app/" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- -------------------- End Projects Section -------------------- -->

    <!-- -------------------- Contact Section -------------------- -->
    <section>
        <?php
        $firstName = $lastName = $email = $number = $contact = $content = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $firstName = data_input($_POST["fname"]);
            $lastName = data_input($_POST["lname"]);
            $email = data_input($_POST["email"]);
            $number = data_input($_POST["number"]);
            $contact = data_input($_POST["contact"]);
            $content = data_input($_POST["content"]);
        }

        function data_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>
        <div class="display-3 d-flex mt-5 justify-content-center contact-header-main">Contact</div>
        <div id="contactForm" class="container">
            <form id="myForm" action="/php/thanks.php" method="post">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <label for="first-name"></label>
                        <input type="text" id="fname" name="fname" placeholder="First name">
                    </div>

                    <div class="col-lg-6">
                        <label for="last-name"></label>
                        <input type="text" id="lname" name="lname" placeholder="Last name">
                    </div>

                    <div class="col-lg-2">
                        <label for="number"></label>
                        <input type="text" id="number" name="number" placeholder="Number">
                    </div>

                    <div class="col-lg-6">
                        <label for="email"></label>
                        <input type="text" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="contact-checkbox-section mt-4">
                        <div>What is your prefered method of contact?</div>
                        <div class="contact-checkboxes d-flex mt-4">
                            <div class="col-lg-2">
                                <label for="contact">Text message</label>
                                <input type="checkbox" id="textbox" name="contact[]" value="text">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact">Phone call</label>
                                <input type="checkbox" id="callbox" name="contact[]" value="call">
                            </div>

                            <div class="col-lg-2">
                                <label for="contact">Email</label>
                                <input type="checkbox" id="emailbox" name="contact[]" value="Email">
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-lg-12">
                        <label for="content"></label>
                        <textarea name="content" id="content" placeholder="Message"></textarea>
                    </div>

                    <button id="submit" class="btn btn-secondary mt-3 col-lg-2" type="submit">Submit form</button>
                </div>
            </form>
        </div>
    </section>
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