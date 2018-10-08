<?php
require_once 'base.php';
class Booking extends Base{
    protected $table_name = 'booking';

    public $showtime_id;
    public $transaction_id;
    public $seat;

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
            (showtime_id, transaction_id, seat) VALUES (?, ? , ?);
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->showtime_id);
        $stmt->bindParam(2, $this->transaction_id);
        $stmt->bindParam(3, $this->seat);
        $stmt->execute();
        return $stmt;
    }
}