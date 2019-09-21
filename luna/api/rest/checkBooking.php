<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/showtime.php';

$db = Database::getConnection();
$showtime_id = $_GET['showtime'];

$showtime = new Showtime($db);

$query = "SELECT h.id, h.name, h.is_imax, h.is_dolby, h.type
          FROM showtime s LEFT JOIN hall h
          ON s.hall_id = h.id
          WHERE s.id = $showtime_id";

$result = $showtime->getAll($query)->fetch_assoc();
$data = array('id' => $result['id'],
    'is_imax' => (bool)$result['is_imax'],
    'is_dolby' => (bool)$result['is_dolby'],
    'type' => $result['type'],
    'name' => $result['name'],
    'occupied' => array()
);

$query = "SELECT seat FROM booking b
        WHERE b.showtime_id = $showtime_id";

$result = $showtime->getAll($query);

while ($row = $result->fetch_assoc()) {
    array_push($data['occupied'], $row['seat']);
}

echo json_encode($data);





