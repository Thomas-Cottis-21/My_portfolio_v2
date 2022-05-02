<?php
session_start();

if (isset($_POST["yes"])) {
    session_destroy();
    header("Location: ../index.php");
}