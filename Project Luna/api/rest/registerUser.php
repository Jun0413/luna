<?php

session_start();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

include_once '../config/database.php';
include_once '../models/user.php';

$db = Database::getConnection();
$user = new User($db);

$name = trim($_POST['name']);
$email = $_POST['email'];
$password = md5($_POST['password']);

$result = ['success' => true];

try {

    // check user exists
    $query = "SELECT * FROM user WHERE email = '$email'";
    $r = $user->get($query);

    if (is_null($r)) {

        // write into database
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->create();

        $result['user_name'] = $name;

        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;

    } else { // user exists
        $result['success'] = false;
        $result['error'] = "User already exists";

    }

} catch (mysqli_sql_exception $ex) {
    $result['success'] = false;
    $result['error'] = $ex->getMessage();
}

echo json_encode($result);

?>