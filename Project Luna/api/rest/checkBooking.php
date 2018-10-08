<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/showtime.php';

$database = new Database();
$db = $database->getConnection();
$showtime_id = $_GET['showtime'];

$showtime = new Showtime($db);

$query = "SELECT h.id, h.name, h.is_imax, h.is_dolby, h.type
          FROM showtime s LEFT JOIN hall h
          ON s.hall_id = h.id
          WHERE s.id = $showtime_id";

$stmt = $showtime->getAll($query)->fetch(PDO::FETCH_ASSOC);
$result = array('id' => $stmt['id'],
    'is_imax' => (bool)$stmt['is_imax'],
    'is_dolby' => (bool)$stmt['is_dolby'],
    'type' => $stmt['type'],
    'name' => $stmt['name'],
    'occupied' => array()
);

$query = "SELECT seat FROM booking b
        WHERE b.showtime_id = $showtime_id";

$stmt = $showtime->getAll($query);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['occupied'], $row['seat']);
}

echo json_encode($result);





