<?php
session_start();
if (isset($_SESSION['user'])) {

    echo '<link rel="stylesheet" href="/css/styles.css">';

    echo 'Hello '.$_SESSION['username'];

    echo ' <a href="?logout">Log out</a>';
    echo ' <a href="login.php">Login</a>';


} else {

    include 'html/register_page.html';

}
?>




