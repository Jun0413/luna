<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/showtime.php';

$database = new Database();
$db = $database->getConnection();

$showtime = new Showtime($db);
$query = "SELECT s.id, c.id as cid, c.name as cinema, m.id as mid, m.name as movie, s.day, s.start_time as time 
          FROM showtime s 
          LEFT JOIN hall h ON s.hall_id = h.id 
          LEFT JOIN cinema c ON h.cinema_id = c.id 
          LEFT JOIN movie m ON s.movie_id = m.id 
          ORDER BY s.id";
$stmt = $showtime->getAll($query);

$result = array();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $item = array(
        "id" => $id,
        "cid" => $cid,
        "cinema" => $cinema,
        "mid" => $mid,
        "movie" => $movie,
        "day" => $day,
        "time" => substr($time, 0, 5)
    );
    array_push($result, $item);
}
echo json_encode($result);