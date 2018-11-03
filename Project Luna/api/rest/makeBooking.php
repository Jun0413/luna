<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' || !isset($_SESSION['showtimes'])) {
    header('Location: home.php');
    die();
}

include_once '../models/transaction.php';
include_once '../models/booking.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$result = ['success' => true];

try {
    $time = time();
    $transaction = new Transaction();
    $transaction->timestamp = $time;
    $transaction->email = $_POST['email'];
    $transaction->name = $_POST['name'];
    $transaction->combo_a = $_SESSION['combo_a'];
    $transaction->combo_b = $_SESSION['combo_b'];
    $transaction->create();
    
    $query = "SELECT id from transaction WHERE `timestamp` = $time";
    $new_transaction = $transaction->get($query);
    $booking = new Booking();
    $booking->transaction_id = $new_transaction['id'];
    
    foreach($_SESSION['showtimes'] as $id => $_seats) {
        $seats = explode(',', $_seats);
        $booking->showtime_id = $id;
        foreach ($seats as $seat) {
            $booking->seat = $seat;
            $booking->create();
        }
    }

    $to = 'f37ee@localhost';
    $subject = 'Luna Cinema - Booking Confirmation';
    $headers = "From: f37ee@localhost" . "\r\n" . "X-Mailer: PHP/" . phpversion();

    $message = "Dear ". $_POST['name'].", here is your booking information:\r\n" .
    "     ITEM                                PRICE\r\n" . 
    "   ----------------------------------------------\r\n";

    require_once '../models/showtime.php';
    $combo_a_price = $_SESSION['combo_a'] * 9;
    $combo_b_price = $_SESSION['combo_b'] * 8.5;    
    $total = $combo_a_price + $combo_b_price;
    $showtime = new Showtime();
    foreach($_SESSION['showtimes'] as $id => $seats) {
        $detail = $showtime->getById($id);
        $time = explode(':', $detail['time']);
        $detail['time'] = date('M d D H:i', mktime($time[0], $time[1], 0,
            date('m'), date('d') + (7 + $detail['day'] - date('w')) % 7, date('Y')));
        $detail['count'] = count(explode(',', $seats));
        $movie_price = $detail['count'] * $detail['price'];
        $total += $movie_price;
        $message .= "   Movie - " . $detail['movie'] . " x" . $detail['count'] . "          $" . number_format($movie_price, 2) . 
                "\r\n   ****    " . $detail['cinema'] . " - " . $detail['hall'] .
                "\r\n   ****    " . $detail['time'] . "Seats: $seats\r\n" .
                "   ----------------------------------------------\r\n";
    }
    if ($_SESSION['combo_a']) {
        $message .= "   Snack - Combo A x" . $_SESSION['combo_a'] . 
        "                    $" . number_format($combo_a_price, 2) . 
        "\r\n   ****    Each @ $9.00\r\n" .
        "   ----------------------------------------------\r\n";
    }
    if ($_SESSION['combo_b']) {
        $message .= "   Snack - Combo B x" . $_SESSION['combo_b'] . 
        "                    $" . number_format($combo_b_price, 2) . 
        "\r\n   ****    Each @ $8.50\r\n" .
        "   ----------------------------------------------\r\n";
    }
    $message .= "   Total Price:                         $" . number_format($total, 2);
    @mail($to, $subject, $message, $headers, '-ff37ee@localhost');
        
    $_SESSION['showtimes'] = [];
    $_SESSION['combo_a'] = $_SESSION['combo_b'] = 0;

} catch (mysqli_sql_exception $ex) {
    $result['success'] = false;
    $result['error'] = $ex->getMessage();
}

echo json_encode($result);

