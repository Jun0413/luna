<?php
require_once 'base.php';
class Showtime extends Base {
    protected $table_name = 'showtime';

    public $hall_id;
    public $movie_id;
    public $day;
    public $start_time;
    public $price;

    public function getById($id) {
        $query = "SELECT s.id, m.name as movie, c.name as cinema, h.name as hall, s.day, s.start_time as time, s.price
                  FROM showtime s
                  LEFT JOIN movie m on s.movie_id = m.id
                  LEFT JOIN hall h on s.hall_id = h.id
                  LEFT JOIN cinema c on h.cinema_id = c.id
                  WHERE s.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }
}