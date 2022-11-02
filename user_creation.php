<?php require("register.class.php")?>

<?php
if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['confirmation_password']) && isset($_POST['email'])&& isset($_POST['name'])) {

    $user = new RegisterUser($_POST['login'], $_POST['password'], $_POST['confirmation_password'], $_POST['email'], $_POST['name']);


}