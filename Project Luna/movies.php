<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/movies.css'),
    'scripts' => array('./libs/javascript/pages/movies.js')
);

require_once './api/models/movie.php';
$movie = new Movie();
$result = $movie->getAll("SELECT * from movie ORDER BY is_showing DESC, id");

$movies = array();
while ($row = $result->fetch_assoc()) {
    extract($row);
    $item = array(
        "id" => $id,
        "name" => $name,
        "genre" => $genre,
        "region" => $region,
        "length" => $length,
        "rating" => $rating,
        "is_showing" => $is_showing == '1'
    );
    array_push($movies, $item);
}

require_once './components/layout_header.php';
?>

<main>
    <section class="top">
        <form>
            <label for="genre" class="select" data-icon-before="genre"><span>Choose Genre</span></label>
            <input type="text" id="genre" name="genre" hidden>
            <label for="region" class="select" data-icon-before="region"><span>Choose Region</span></label>
            <input type="text" id="day" name="region" hidden>
            <label for="rating" class="select" data-icon-before="child"><span>Choose Rating</span></label>
            <input type="text" id="rating" name="rating" hidden>
            <label for="sort" class="select" data-icon-before="sort"><span>Sorting</span></label>
            <input type="text" id="sort" name="sort" hidden>
        </form>
    </section>
    <section class="bottom">
        <div class="movies">
            <?php foreach ($movies as $m) { ?>
                <div class="movie">
                    <div class="wrapper<?php echo ($m['is_showing'] ? '""' :  ' disabled"') ?>
                     data-id="<?php echo $m['id'] ?>"
                     data-genre="<?php echo $m['genre'] ?>"
                     data-rating="<?php echo $m['rating'] ?>">
                        <img src="./images/posters/0.jpg" class="loading" alt="<?php echo $m['name'] ?>">
                    </div>
                    <h4><?php echo $m['name'] . ($m['is_showing'] ? '' : '*') ?></h4>
                    <p><?php echo $m['length'] ?> min</p>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>