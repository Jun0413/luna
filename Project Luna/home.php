<?php
session_start();
require_once './api/models/movie.php';
require_once './api/models/cinema.php';
$movie = new Movie();
$cinema = new Cinema();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $showtime_id = $_POST['showtime'];
    $movie_name = $_POST['movie'];
    $cinema_name = $_POST['cinema'];
    $my_cinema = $cinema->getByName($cinema_name);
    $my_movie = $movie->getByName($movie_name);
    if ($showtime_id) {
        header("Location: booking.php?showtime=" . $showtime_id);
        die();
    }
    $cinema_id = $my_cinema ? $my_cinema['id'] : 0;
    $movie_id = $my_movie ? $my_movie['id'] : 0;
    header('Location: showtime.php?cinema=' . $cinema_id . '&movie=' . $movie_id);
}

$config = array(
    'navLink' => 'home',
    'styles' => array('./libs/css/pages/home.css'),
    'scripts' => array('./libs/javascript/slideshow.js', './libs/javascript/slider.js', './libs/javascript/pages/home.js')
);

$query = "SELECT id, name, length, genre
          FROM movie WHERE is_showing = 0";
$result = $movie->getAll($query);
$movies = array();
while ($row = $result->fetch_assoc()) {
    array_push($movies, $row);
}


require_once './components/layout_header.php';
?>

<main>
    <section class="top">
        <?php
        require_once './components/slideshow.php';
        $show_config = array(
            'delay' => 3000,
            'speed' => 500,
            'items' => array(
                array('_name' => 'Crazy Rich Asian', '_src' => 'slideshow/crazy_rich_asian.jpg', '_target' => 'movie.php?movie=7'),
                array('_name' => 'Europe Raiders', '_src' => 'slideshow/europe_raiders.jpg', '_target' => 'movie.php?movie=16'),
                array('_name' => 'Fantastic Beast', '_src' => 'slideshow/fantastic_beasts.jpg', '_target' => 'movie.php?movie=9'),
                array('_name' => 'Sui Dhaaga', '_src' => 'slideshow/sui_dhaaga.jpg', '_target' => 'movie.php?movie=20'),
            )
        );
        slide_show($show_config);
        ?>
        <form id="quickBuy" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <label for="cinema" class="select" data-icon-before="location"><span>Choose Cinema</span></label>
            <input type="text" id="cinema" name="cinema" hidden>
            <label for="movie" class="select" data-icon-before="movie"><span>Choose Movie</span></label>
            <input type="text" id="movie" name="movie" hidden>
            <label for="time" class="select" data-icon-before="time"><span>Choose Time</span></label>
            <input type="text" id="time" name="time" hidden>
            <input type="text" id="showtime" name="showtime" hidden>
            <div class="buttons">
                <button type="reset" class="raised-button"><span>reset</span></button>
                <button type="submit" class="raised-button primary"><span>go</span></button>
            </div>
        </form>
    </section>
    <section class="bottom">
        <h2>upcoming</h2>
        <div class="slider">
            <div class="container">
                <?php foreach ($movies as $m) { ?>
                <div class="movie" data-id="<?php echo $m['id'] ?>">
                    <img src="./images/posters/0.jpg" alt="<?php echo $m['name'] ?>">
                    <div class="info">
                        <span><?php echo $m['name'] ?></span>
                        <span><?php echo $m['genre'] ?></span>
                        <span><?php echo $m['length'] ?> min</span>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="controls">
            <button class="control_left">&#10094;</button>
            <button class="control_right">&#10095;</button>
        </div>
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>
