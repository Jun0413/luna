<?php
session_start();

if (!isset($_SESSION['showtimes'])) {
    header('location: home.php');
    die();
}

$combo_a_price = $_SESSION['combo_a'] * 9;
$combo_b_price = $_SESSION['combo_b'] * 8.5;
$total = $combo_a_price + $combo_b_price;

$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/payment.css'),
    'scripts' => array('./libs/javascript/pages/payment.js')
);

require_once './components/layout_header.php';
?>

<main>
    <section class="left">
        <h2>payment summary
            <a href="showtime.php?cinema=1&movie=0">Buy More ></a>
        </h2>
        <table>
            <thead>
            <tr>
                <td>Item</td>
                <td>Price</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php
                require_once './api/models/showtime.php';
                $showtime = new Showtime();
                $class = count($_SESSION['showtimes']) > 2 ? 'header' : 'header expanded';
                foreach($_SESSION['showtimes'] as $id => $seats) {
                    $detail = $showtime->getById($id);
                    $time = explode(':', $detail['time']);
                    $detail['time'] = date('M d D H:i', mktime($time[0], $time[1], 0,
                        date('m'), date('d') + (7 + $detail['day'] - date('w')) % 7, date('Y')));
                    $detail['count'] = count(explode(',', $seats));
                    $movie_price = $detail['count'] * $detail['price'];
                    $total += $movie_price;
                    echo "
                        <tr class='$class' onclick='this.classList.toggle(\"expanded\")'>
                            <td>Movie - ".$detail['movie']." x".$detail['count']."</td>
                            <td>$" . number_format($movie_price, 2) . "</td>
                            <td><i data-icon='bin' data-id='$id'></i></td>
                        </tr>
                        <tr class='sub'>
                            <td colspan='3'>".$detail['cinema']." - ".$detail['hall']."</td>
                        </tr>
                        <tr class='sub'>
                            <td colspan='3'>".$detail['time']."</td>
                        </tr>
                        <tr class='sub'>
                            <td colspan='3'>Seats: $seats</td>
                        </tr>
                    ";
                }
                if ($_SESSION['combo_a']) {
                    echo "
                        <tr class='header combo expanded' onclick='this.classList.toggle(\"expanded\")'>
                            <td>Snack - Combo A x" . $_SESSION['combo_a'] . "</td>
                            <td>$" . number_format($combo_a_price, 2) . "</td>
                            <td><i data-icon='bin' data-combo='a'></i></td>
                        </tr>
                        <tr class='sub'>
                            <td colspan='3'>Each @ $9.00</td>
                        </tr>
                        ";
                }
                if ($_SESSION['combo_b']) {
                    echo "
                        <tr class='header combo expanded' onclick='this.classList.toggle(\"expanded\")'>
                            <td>Snack - Combo B x" . $_SESSION['combo_b'] . "</td>
                            <td>$" . number_format($combo_b_price, 2) . "</td>
                            <td><i data-icon='bin' data-combo='b'></i></td>
                        </tr>
                        <tr class='sub'>
                            <td colspan='3'>Each @ $8.50</td>
                        </tr>
                        ";
                }
                ?>
            </tbody>
            <tfoot>
            <tr>
                <td>Total Price:</td>
                <td>$<?php echo number_format($total, 2) ?></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </section>

    <section class="right">
        <p class="warning"><span>Please fill the form!</span> <i onclick="this.parentElement.style.display='none'">&times;</i></p>
        <form action="" id="payment" name="profile">
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
        <button class="raised-button primary pay-button" disabled>confirm</button>
    </section>
</main>


<?php
require_once './components/layout_footer.php';
?>
