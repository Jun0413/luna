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
</head>
<body>
<nav>
    <div class="left-nav">
        <a href="home.php"><h1>LUNA</h1></a>
        <ul>
            <?php
            $links = ['home', 'cinemas', 'movies', 'contact'];
            foreach ($links as $link) {
                echo "<li><a href='$link.php'" . ($config['navLink'] == $link ? " class='active'" : "") . ">$link</a></li>";
            }
            ?>
        </ul>
    </div>
    <div class="right-nav">
        <form class="search-bar" action="search.php">
            <input type="text" id="search" name="q" 
            value="<?php echo isset($_GET['q']) ? $_GET['q'] : '' ?>"
            placeholder="Search movies or cinemas...">
            <button><i data-icon="search"></i></button>
        </form>
        <div class="profile">
            <?php 
            $_SESSION['email'] = 'test@gmail.com';
            $_SESSION['name'] = 'Jonason';
                echo "
                <a href='user.php'>
                <div class='info'>";
                if (isset($_SESSION['email'])) {
                    echo "<h4>".$_SESSION['name']."</h4>
                    <button onclick='logout()'>
                        <i data-icon='logout'></i>Logout
                    </button>";
                } else {
                    echo "<button onclick='login()'>
                        <i data-icon='login'></i>Login
                    </button>";
                }
                echo "</div>
                    <div class='profile-pic'></div>
                </a>";
            ?>
        </div>
    </div>
</nav>