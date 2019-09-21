<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/showtime.css'),
    'scripts' => array('./libs/javascript/pages/showtime.js')
);

require_once './components/layout_header.php';
?>

<main>
    <section class="hor_container"></section>
    <section class="movie"></section>
</main>

<?php
require_once './components/layout_footer.php';
?>
