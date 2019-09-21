<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/search.css'),
    'scripts' => array()
);

require_once './components/layout_header.php';
require_once './api/models/movie.php';

$terms = explode(' ', preg_replace('!\s+!', ' ', trim($_GET['q'])));
$movies = [];
$cinemas = [];
$movie = new Movie();

foreach($terms as $term) {
    $query = "SELECT * FROM movie m WHERE 
    LOWER(m.name) LIKE LOWER('%$term%') 
    OR LOWER(m.genre) LIKE LOWER('%$term%') 
    OR LOWER(m.region) LIKE LOWER('%$term%') 
    OR LOWER(m.overview) LIKE LOWER('%$term%') 
    OR LOWER(m.director) LIKE LOWER('%$term%') 
    OR LOWER(m.length) LIKE LOWER('%$term%') 
    OR LOWER(m.cast) LIKE LOWER('%$term%') 
    ";
    $result = $movie->getAll($query);
    while($row = $result->fetch_assoc()) {
        if(!isset($movies[$row['id']])) {
            $movies[$row['id']] = [
                'name'=> $row['name'],
                'genre'=> $row['genre'],
                'length'=> $row['length']
            ];
        }
    }
    $query = "SELECT * FROM cinema c WHERE 
    LOWER(c.name) LIKE LOWER('%$term%') 
    OR LOWER(c.address) LIKE LOWER('%$term%')  
    OR LOWER(c.phone) LIKE LOWER('%$term%') 
    ";
    $result = $movie->getAll($query);
    while($row = $result->fetch_assoc()) {
        if(!isset($cinemas[$row['id']])) {
            $cinemas[$row['id']] = [
                'name'=> $row['name'],
                'address'=> $row['address'],
                'phone'=> $row['phone']
            ];
        }
    }
}


?>

<main>
    <?php 
    $count = count($cinemas);
    echo "<section class='cinemas'>
            <h1 data-count='".$count.($count > 1 ? ' results' : ' result')."'><span>Cinemas</span></h1>
    ";
        foreach($cinemas as $id => $c) {
            echo "<a href='showtime.php?cinema=$id&movie=0'>
                <img src='./images/cinemas/$id.jpg'>
                <div>
                    <h2>".$c['name']."</h2>
                    <p>".$c['address']."</p>
                    <p>".$c['phone']."</p>
                </div>
            </a>";
        } 
    echo "</section>";
    $count = count($movies);
    echo "<section class='movies'>
           <h1 data-count='".$count.($count > 1 ? ' results' : ' result')."'><span>Movies</span></h1>
    ";
    foreach($movies as $id => $m) {
        echo "<a href='movie.php?movie=$id'>
            <img src='./images/posters/$id.jpg'>
            <h2>".$m['name']."</h2>
            <p>".$m['genre']."</p>
            <p>".$m['length']." min</p>
        </a>";
    }
    echo "</section>";
    ?>
</main>

<?php
require_once './components/layout_footer.php';
?>
