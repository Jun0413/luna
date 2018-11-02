<!DOCTYPE html>
<html lang="en"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Luna - Movie Ticket Booking</title>
    <link rel="stylesheet" href="./libs/css/global.css">
    <?php
    foreach ($config['styles'] as $style) {
        echo "<link rel='stylesheet' href='$style'>";
    }
    ?>
    <link rel="stylesheet" href="./libs/css/login.css">
</head>
<body>
<nav>
    <a href="home.php"><h1>LUNA</h1></a>
    <ul>
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }
        $links = ['home', 'cinemas', 'movies', 'contact'];
        foreach ($links as $link) {
            echo "<li><a href='$link.php'" . ($config['navLink'] == $link ? " class='active'" : "") . ">$link</a></li>";
        }
        if (isset($_SESSION['user_name'])) {
            echo "<li><a href='user.php'>".$_SESSION['user_name']."</a></li>";
            echo "<li><a href='./api/rest/logoutUser.php?p=".$config['navLink']."'>log out</a></li>";
        } else {
            echo "<li onclick=\"document.getElementById('login-modal').style.display='block';document.body.style.overflow='hidden'\"><a>login</a></li>";
        }
        include_once 'login.php';
        ?>
    </ul>
</nav>