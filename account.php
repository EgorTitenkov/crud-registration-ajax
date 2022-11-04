
<?php
session_start();
if (!isset($_SESSION['user'])){
    header("location:login.php"); exit();
}

if (isset($_GET['logout'])){
    unset($_SESSION['user']);
    header("location:login.php"); exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/styles.css">

    <title>User account</title>
</head>
<body>

<div class="content">
    <header>
        <h2>Hello <?php echo $_SESSION['username'] ?> </h2>
        <a href="?logout">Log out</a>
    </header>

</div>
</body>
</html>

