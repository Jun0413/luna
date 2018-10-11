<?php
session_start();
require_once './api/config/database.php';
require_once './api/models/showtime.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' || !isset($_POST['showtime']) || !isset($_POST['seats'])) {
    header('Location: home.php');
    die();
}

$_SESSION['combo_a'] = $_POST['combo_a'];
$_SESSION['combo_b'] = $_POST['combo_b'];
$_SESSION['showtime'] = $_POST['showtime'];
$_SESSION['seats'] = $_POST['seats'];

$database = new Database();
$db = $database->getConnection();
$showtime = new Showtime($db);
$detail = $showtime->getById($_POST['showtime']);
$time = explode(':', $detail['time']);
$detail['time'] = date('M d D H:i', mktime($time[0], $time[1], 0,
    date('m'), date('d') + (7 + $detail['day'] - date('w')) % 7, date('Y')));
$detail['count'] = count(explode(',', $_POST['seats']));

$movie_price = $detail['count'] * $detail['price'];
$combo_a_price = $_POST['combo_a'] * 9;
$combo_b_price = $_POST['combo_b'] * 8.5;
$total = $movie_price + $combo_a_price + $combo_b_price;

$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/payment.css'),
    'scripts' => array('./libs/javascript/pages/payment.js')
);

require_once './components/layout_header.php';
?>

<main>
    <section class="left">
        <h2>payment summary</h2>
        <table>
            <thead>
            <tr>
                <td>Item</td>
                <td>Price</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Movie - <?php echo $detail['movie'] ?> x<?php echo $detail['count'] ?></td>
                <td>$<?php echo number_format($movie_price, 2) ?></td>
            </tr>
            <tr class="sub">
                <td colspan="2"><?php echo $detail['cinema'] ?> - <?php echo $detail['hall'] ?></td>
            </tr>
            <tr class="sub">
                <td colspan="2"><?php echo $detail['time'] ?></td>
            </tr>
            <tr class="sub">
                <td colspan="2">Seats: <?php echo $_POST['seats'] ?></td>
            </tr>
            <?php
            if ($_POST['combo_a']) {
                echo "
                    <tr>
                        <td>Snack - Combo A x" . $_POST['combo_a'] . "</td>
                        <td>$" . number_format($combo_a_price, 2) . "</td>
                    </tr>
                    <tr class='sub'>
                        <td colspan='2'>Each @ $9.00</td>
                    </tr>
                    ";
            }
            if ($_POST['combo_b']) {
                echo "
                    <tr>
                        <td>Snack - Combo A x" . $_POST['combo_b'] . "</td>
                        <td>$" . number_format($combo_b_price, 2) . "</td>
                    </tr>
                    <tr class='sub'>
                        <td colspan='2'>Each @ $8.50</td>
                    </tr>
                    ";
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <td>Total Price:</td>
                <td>$<?php echo number_format($total, 2) ?></td>
            </tr>
            </tfoot>
        </table>
    </section>

    <section class="right">
        <p class="warning"><span>Please fill the form!</span> <i onclick="this.parentElement.style.display='none'">&times;</i></p>
        <form action="" id="payment">
            <input type="text" placeholder="Your Name" name="name" id="name" required>
            <input type="email" placeholder="Email Address" name="email" id="email" required>
        </form>
        <p>Please select a payment method:</p>
        <div class="payments">
            <input type="radio" name="method" id="visa" hidden checked form="payment" required>
            <label class="payment" for="visa">
                <i data-icon="visa"></i>
                <span>VISA</span>
            </label>
            <input type="radio" name="method" id="mastercard" hidden form="payment" required>
            <label class="payment" for="mastercard">
                <i data-icon="mastercard"></i>
                <span>Mastercard</span>
            </label>
            <input type="radio" name="method" id="paypal" hidden form="payment" required>
            <label class="payment" for="paypal">
                <i data-icon="paypal"></i>
                <span>Paypal</span>
            </label>
            <input type="radio" name="method" id="credit" hidden form="payment" required>
            <label class="payment" for="credit">
                <i data-icon="credit"></i>
                <span>Credit Card</span>
            </label>
        </div>
        <button class="raised-button primary" disabled>confirm</button>
    </section>
</main>


<?php
require_once './components/layout_footer.php';
?>
