<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/booking.css'),
    'scripts' => array('./libs/javascript/pages/booking.js')
);

require_once './api/config/database.php';
$database = new Database();
$db = $database->getConnection();

require_once './components/layout_header.php';
?>

<main>
    <aside class="left-panel">
       <h2>Snack</h2>
        <div class="item">
            <img src="./images/combo_a.jpg" alt="Combo A">
            <div class="content">
                <label for="combo_a">Combo A <br>$9.00</label>
                <div class="input">
                    <input type="number" name="combo_a" id="combo_a" value="0" readonly>
                    <button class="plus">+</button>
                    <button class="minus">-</button>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="./images/combo_b.jpg" alt="Combo B">
            <div class="content">
                <label for="combo_b">Combo B <br>$8.50</label>
                <div class="input">
                    <input type="number" name="combo_b" id="combo_b" value="0" readonly>
                    <button class="plus">+</button>
                    <button class="minus">-</button>
                </div>
            </div>
        </div>
        <button class="control"></button>
    </aside>

    <section class="top">
        <label for="cinema" class="select" data-icon-before="location"><span>Choose Cinema</span></label>
        <input type="text" id="cinema" name="cinema" hidden>
        <label for="day" class="select" data-icon-before="date"><span>Choose Date</span></label>
        <input type="text" id="day" name="da" hidden>
        <label for="time" class="select" data-icon-before="time"><span>Choose Time</span></label>
        <input type="text" id="time" name="time" hidden>
        <input type="text" id="showtime" name="showtime" hidden>
        <button class="raised-button primary">pay</button>
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>
