<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' || !isset($_SESSION['showtime']) || !isset($_SESSION['seats'])) {
    header('Location: home.php');
    die();
}

include_once '../config/database.php';
include_once '../models/transaction.php';
include_once '../models/booking.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$database = new Database();
$db = $database->getConnection();
$result = array(
    'success' => true
);

try {
    $seats = explode(',', $_SESSION['seats']);
    $time = time();
    $transaction = new Transaction($db);
    $transaction->email = $_POST['email'];
    $transaction->name = $_POST['name'];
    $transaction->combo_a = $_SESSION['combo_a'];
    $transaction->combo_b = $_SESSION['combo_b'];
    $transaction->timestamp = $time;
    $transaction->create();

    $query = "SELECT id from transaction WHERE `timestamp` = $time";
    $new_transaction = $transaction->get($query);

    $booking = new Booking($db);
    $booking->transaction_id = $new_transaction['id'];
    $booking->showtime_id = $_SESSION['showtime'];
    foreach ($seats as $seat) {
        $booking->seat = $seat;
        $booking->create();
    }
} catch (PDOException $ex) {
    $result['success'] = false;
    $result['error'] = $ex->getMessage();
}

echo json_encode($result);

