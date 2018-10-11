<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php';
include_once '../models/movie.php';

$database = new Database();
$db = $database->getConnection();

$movie = new Movie($db);
$stmt = $movie->getAll(null);

$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $item = array(
        "id" => $id,
        "name" => $name,
        "genre" => $genre,
        "region" => $region,
        "length" => $length,
        "rating" => $rating,
        "is_showing" => $is_showing == '1'
    );
    array_push($result, $item);
}
echo json_encode($result);