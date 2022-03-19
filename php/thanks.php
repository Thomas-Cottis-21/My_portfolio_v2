<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>

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
    <div class="container-fluid">
        <div class="thanks-page">
            <div class="thanks-header-main">
                <div class="mt-4">Thank you</div>
            </div>
            <div class="thanks-information-header">
                <div>
                    <div class="mt-4">Your confirmation email was sent!</div>
                    <div class="mt-1">Please review your recorded information: </div>
                </div>
            </div>
            <div class="thanks-information-content">
                <div>
                    <!-- php goes here -->
                    <?php

                        function data_input($data) {
                            $data = htmlspecialchars($data);
                            return $data;
                        }

                        $firstName = data_input($_POST["fname"]);
                        $lastName = $_POST["lname"];
                        $email = $_POST["email"];
                        $number = $_POST["number"];
                        $contact = array (
                            $_POST["Text"], $_POST["Call"], $_POST["Email"]
                        );
                        $content = $_POST["content"];

                        if (!empty($number)) {
                            $number = " | " . $number;
                        }
                    ?>
                    <ul>
                        <li><?=$firstName . " " . $lastName?></li>
                        <li><?=$email . $number?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
        $to = $email;
        $subject = "Thank you from Thomas Cottis";
        $message = "Thank you for looking over my site and reaching out to me! I'll get back to you within 24 hours!";
        $headers = "From: thomascottis@thomasandco.xyz";
        
        mail($to, $subject, $message, $headers);

        $toThomas = "thomascottis@thomasandco.xyz";
        $subjectThomas = "New Message!";
        $messageThomas = $content;
        $headersThomas = "From: thomascottis@thomasandco.xyz";

        mail($toThomas, $subjectThomas, $messageThomas, $headersThomas);
    ?>
</body>
<script src="/js/main.js"></script>
</html>