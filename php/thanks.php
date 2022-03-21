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
            <div class="thanks-information-content">
                <div>
                <!-- php goes here -->
                <?php
                    function data_input($data) {
                        $data = htmlspecialchars($data);
                        $data = trim($data);
                        $data = stripslashes($data);
                            return $data;
                    }
                        $firstName = data_input($_POST["fname"]);
                        $lastName = data_input($_POST["lname"]);
                        $email = data_input($_POST["email"]);
                        $number = data_input($_POST["number"]);
                        $contact = array (
                            $_POST["Text"], $_POST["Call"], $_POST["Email"]);
                        $content = data_input($_POST["content"]);

                        $to = $email;
                        $subject = "Thank you from Thomas Cottis";
                        $message = "Thank you for looking over my site and reaching out to me! I'll get back to you within 24 hours!";
                        
                        $email_to = "thomascottis@thomasandco.xyz";
                        $email_subject = "New Message!";
                        $email_message = $firstName . "\n" . $email . "\n" . $number . "\n" . wordwrap($content, 70, "\r\n");
                        $headers = "From: $name, $email";

                        mail($email_to, $email_subject, $email_message, $headers);
                ?>
                    <div class="thanks-header-main">
                        <div class="mt-4">Thank you</div>
                    </div>
                    <!-- php email form information end -->
                    <div class="thanks-information-content">
                        <?php
                            if (mail($to, $subject, $message)) {
                                ?><div class="mt-4"><?="Your confirmation email was sent!"?></div>
                                <div class="mt-1"><?="Please double check your recorded information: "?></div>
                                <?php
                            } else {
                                ?><div class="mt-1"><?="Unfortunatley, your email was not sent! Please try again."?></div>
                                <div class="mt-1"><?="Please revise your contact information, as it may have been the cause:"?></div> <?php
                            }
                        ?>
                        <?php
                            if (!empty($number)) {
                                $number = " | " . $number;
                            }
                        ?>
                        <ul>
                            <li><?=$firstName . " " . $lastName?></li>
                            <li><?=$email . $number?></li>
                            <li>
                            <?php
                                foreach($contact as $display) {
                                    ?><span><?=$display . " "?></span><?php
                                }
                            ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/main.js"></script>
</body>
</html>