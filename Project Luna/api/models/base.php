<?php
class Base {
    protected $conn;
    protected $table_name = 'booking';

    public $id;
    public $name;
    public $showtime_id;
    public $transaction_id;
    public $seat;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($query) {
        $query = $query == null ? "SELECT * FROM" . $this->table_name : $query;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }

    public function getByName($name) {
        if (!$name) return null;
        $query = "SELECT * FROM " . $this->table_name . " WHERE name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();
        return $stmt->rowCount() ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }
}