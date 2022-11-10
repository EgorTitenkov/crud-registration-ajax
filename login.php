<?php
session_start();

if (isset($_GET['logout'])) {
    unset($_SESSION['user']);
    header("location:login.php");
    exit();
}

if (isset($_SESSION['user'])) {

    echo '<link rel="stylesheet" href="/css/styles.css">';

    echo 'Hello '.$_SESSION['username'];

    echo '<a href="?logout">Log out</a>';

    echo ' <a href="index.php">Register</a>';

} else {
    include 'html/login_page.html';
}
?>


