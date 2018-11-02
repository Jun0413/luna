<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/movie.css'),
    'scripts' => array('./libs/javascript/pages/movie.js')
);

require_once './components/layout_header.php';
?>

<main>
    <section class='top'>
    <?php
        require_once './components/slideshow.php';
        $movieId = $_GET['movie'];
        $show_config = array(
                'delay' => 4000,
                'speed'=> 500,
                'items' => array(
                        array('_name' => 'Photo 1', '_src' => 'photos/'.$movieId.'_1.jpg', '_target' => ''),
                        array('_name' => 'Photo 2', '_src' => 'photos/'.$movieId.'_2.jpg', '_target' => ''),
                        array('_name' => 'Photo 3', '_src' => 'photos/'.$movieId.'_3.jpg', '_target' => '')
                )
        );
        slide_show($show_config);
    ?>
    <div id='text_container'>
        <?php
            require_once './api/models/movie.php';
            $movie = new Movie();
            $movie_details = $movie->getById($movieId);

            echo "<p id='movie_name'>".$movie_details['name']."</p>";
            echo "<hr>";
            echo "<p id='tab_name'>Overview</p>";
            echo "<div id='description'>";

            /* render overview */
            echo "<p>".$movie_details['overview']."</p>";

            /* render details */
            // ...

            echo '</div>';

            /* store for display */
            echo "<div id='overview_text' style='display:none'><p>".$movie_details['overview']."</p></div>";

            echo '<div id="details_text" style="display:none">';
            echo '<table>';
            echo '<tr>';
            echo '<td>Genre: '.$movie_details['genre'].'</td>';
            echo '<td>Region: '.$movie_details['region'].'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Rating: '.$movie_details['rating'].'</td>';
            echo '<td>Length: '.$movie_details['length'].'min</td>';
            echo '</tr>';
            echo '<tr>';
            echo "<td colspan='2'>Director: ".$movie_details['director']."</td>";
            echo '</tr>';
            echo '<tr>';
            echo "<td colspan='2'>Cast: ".$movie_details['cast']."</td>";
            echo '</tr>';
            echo '</table>';
            echo '</div>';

            /* check if movie is available then renders the button */
            if ($movie_details['is_showing'] == '1') {
                echo "<button id='book_btn' class='live_btn' onclick='clickBook(\"".$movie_details['id']."\")'>Book</button>";
            } else {
                echo "<button id='book_btn' class='dead_btn'>Coming Soon</button>";
            }
        ?>
        <!-- </div> -->
    </div>
    <!-- <button id='overview_btn' onclick='return clickOverview()'>overview</button> -->
    <!-- <button id='details_btn' onclick='return clickDetails()'>details</button> -->
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>