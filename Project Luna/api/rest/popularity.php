<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF8");

include("../config/database.php");

$conn = Database::getConnection();

$query = "select movie.id, movie.name, ifnull(mv_cnt.popularity, 0) as popularity from movie left join (select st.movie_id, count(*) as popularity from showtime as st, booking as bkn where st.id = bkn.showtime_id group by st.movie_id) as mv_cnt on movie.id = mv_cnt.movie_id";
$result = $conn->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
    extract($row);
    $data[$id] = $popularity;
}

echo json_encode($data);
?>