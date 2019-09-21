<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../models/movie.php';
$movie = new Movie();
$result = $movie->getAll(null);

$data = array();
while ($row = $result->fetch_assoc()) {
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
    array_push($data, $item);
}
echo json_encode($data);