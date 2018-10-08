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
    <a href="home.php"><h1>LUNA</h1></a>
    <ul>
        <?php
        $links = ['home', 'cinemas', 'movies', 'contact'];
        foreach ($links as $link) {
            echo "<li><a href='$link.php'" . ($config['navLink'] == $link ? " class='active'" : "") . ">$link</a></li>";
        }
        ?>
    </ul>
</nav>