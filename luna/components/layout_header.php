<!DOCTYPE html>
<html lang="en"></html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Luna - Movie Ticket Booking</title>
    <link rel="stylesheet" href="./libs/css/global.css">
    <link rel="stylesheet" href="./libs/css/login.css">
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
            if (!isset($_SESSION)) {
                session_start();
            }
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
            placeholder="Search movies or cinemas..." autocomplete="off">
            <button><i data-icon="search"></i></button>
        </form>
        <div class="profile">
            <div class='user-info'>
            <?php 
                if (isset($_SESSION['user_name'])) {
                    echo "<h4>".$_SESSION['user_name']."</h4>
                        <button onclick='logout(\"".$config['navLink']."\")'>
                            <i data-icon='logout'></i>Logout
                        </button>
                    </div>
                    <a href='user.php' class='user-pic'></a>";
                } else {
                    echo "<button onclick='login()'>
                        <i data-icon='login'></i>Login
                    </button>
                    </div>
                    <a href='#' class='user-pic'></a>";
                }
                ?>
        </div>
    </div>
</nav>
<?php
    include_once 'login.php';
?>