<?php
$config = array(
    'navLink' => 'cinemas',
    'styles' => array('./libs/css/pages/cinemas.css'),
    'scripts' => array('./libs/javascript/pages/cinemas.js')
);

require_once './api/config/database.php';
$database = new Database();
$db = $database->getConnection();

require_once './components/layout_header.php';
?>

<main>
    <div>
        <img src="./images/cinemas/banner.jpg" id='banner'>
    </div>

    <section>
        <div class='cinemas'>
            <a href="showtime.php?cinema=1&movie=0">
                <img src="./images/cinemas/1.jpg">
                <div>
                    <h1 data-icon-after="dolby" class="icon">Luna Clementi</h1>
                    <p>3150 Commonwealth Avenue West</p>
                    <p>68129580</p>
                </div>
            </a>
            <a href="showtime.php?cinema=2&movie=0">
                <img src="./images/cinemas/2.jpg">
                <div>
                    <h1>Luna Bedok</h1>
                    <p>315 New Upper Changi Road</p>
                    <p>68467347</p>
                </div>
            </a>
            <a href="showtime.php?cinema=3&movie=0">
                <img src="./images/cinemas/3.jpg">
                <div>
                    <h1 data-icon-after="imax" class="icon">Luna Orchard</h1>
                    <!-- <label ><span>Choose Cinema</span></label> -->
                    <p>2 Orchard Turn</p>
                    <p>68238801</p>
                </div>
            </a>
            <a href="showtime.php?cinema=4&movie=0">
                <img src="./images/cinemas/4.jpg">
                <div>
                    <h1 data-icon-after="imax" class="icon">Luna Bayfront<span data-icon-after="dolby" class="icon"></span></h1>
                    <p>10 Bayfront Avenue</p>
                    <p>68018956</p>
                </div>
            </a>
        </div>    
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>
