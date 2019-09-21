<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../models/user.php';

session_start();

$db = Database::getConnection();
$user = new User($db);

$email = $_POST['email'];
$password = md5($_POST['password']);

$result = ['success' => false];

try {

    // check user exists
    $query = "SELECT * FROM user WHERE email = '$email' and password = '$password'";
    $r = $user->get($query);

    if (!is_null($r)) {
        $result['success'] = true;
        $result['name'] = $r['name'];
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $r['name'];
    } else {
        $result['error'] = "Wrong email or password";
    }

} catch (mysqli_sql_exception $ex) {
    $result['error'] = $ex->getMessage();        
}

echo json_encode($result);

?>