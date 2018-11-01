<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/showtime.css'),
    'scripts' => array('./libs/javascript/pages/showtime.js')
);

require_once './components/layout_header.php';
?>

<main>
    <section class="hor_container">
        <!-- <div class="ver_tab">
        </div>
        <div class="ver_container">
            <div class="hor_tab">
            </div> 
            <div id="showtime_table">
            </div>
        </div> -->
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>
