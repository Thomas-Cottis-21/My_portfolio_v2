<?php
//starting session to be able to use session variables
    session_start();

//create conenction to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "my_portfolio_v2_test";

//filter incoming data
    function data_filter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

//this variable is what the user types in as a username and will be tested further on
    $loginUsername = data_filter($_POST["username"]);

//this variable is what the user types in as a password and will be tested further on
    $loginPassword = data_filter($_POST["password"]);

//can't remember why I wrote this... Look it up!
    $_SESSION["post-data"] = $_POST;

//try and catch to connect to database or return and show error
    try {
        //creating new PHP data object connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        //retrieving errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        echo "Database connection successful -> Access Granted!";

        //prepared statement that will fetch data from the database to verify against what the user input is
        $stmt = $conn->prepare('SELECT accountId, username, password, name FROM accounts WHERE username = :username');

        //binding the username column to the user input in order to compare the two
        $stmt->bindParam(":username", $loginUsername);

        //executing prepared statement
        $stmt->execute();

        //fetching and storing the variable in $user
        $user = $stmt->fetch();

        //assigning variables to array to then compare
        $userId = $user[0];
        $userName = $user[1];
        $userPassword = $user[2];
        $userRealName = $user[3];

        if ($userName === $loginUsername && $userPassword === $loginPassword) {
            //redirects the page to the home page
            header("Location: home.php");

            echo "username and password match with the user's input (if statement is running)";
            
            //starts a new session
            session_regenerate_id();

            //keeps track of the users login session
            $_SESSION["loggedin"] = TRUE;

            //the users name given from the database
            $_SESSION["name"] = $userRealName;

            //the session id
            $_SESSION["id"] = $userId;

        } else {
            //redirects the user back to the index page if the credentials that they input are wrong
            header("Location: /index.php");

            //unsetting logged in variable
            $_SESSION["loggedin"] = FALSE;


            echo "Credentials have failed";
        }
        
    } catch(PDOException $error) {
        //user is redirected back to the index page if the database cannot be connected to
        header("Location: /index.php");

        //runs the error to the log
        echo "<script>console.log('ERROR: " . addslashes($error->getMessage()) . "')</script>";


        echo "Database failed to connect";
    }

    //kills the connection so that it doesn't loop
    $conn = null;
