<?php

session_start();
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$data = isset($_POST['type']) ? $_POST : json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] == 'GET' || !isset($data)) {
    die();
}


$result = ["success" => true];
// try {
    switch ($data['type']) {
        case 'UPDATE_COMBO':
            $_SESSION['combo_a'] = $data['combo_a'];
            $_SESSION['combo_b'] = $data['combo_b'];
            break;
        case 'ADD_SHOWTIME':
            if (!isset($_SESSION['showtimes'])) {
                $_SESSION['showtimes'] = [];
            }
            $_SESSION['showtimes'][$data['showtime']] = $data['seats'];
            header('location: ../../payment.php');
            break;
        case 'REMOVE_SHOWTIME':
            unset($_SESSION['showtimes'][$data['showtime']]);
    }
// } catch (Exception $ex) {
    // $result['success'] = false;
// }

echo json_encode($result);





