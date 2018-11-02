<?php
require_once dirname(__DIR__).'/config/database.php';

class Base {
    protected $conn;
    protected $table_name = '';

    public $id;
    public $name;
    public $showtime_id;
    public $transaction_id;
    public $seat;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAll($query) {
        $query = $query == null ? "SELECT * FROM " . $this->table_name : $query;
        $result = $this->conn->query($query);
        return $result;
    }

    public function get($query) {
        $result = $this->conn->query($query);
        return $result->num_rows ? $result->fetch_assoc() : null;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = $id";
        $result = $this->conn->query($query);

        return $result->num_rows ? $result->fetch_assoc() : null;
    }

    public function getByName($name) {
        if (!$name) return null;
        $query = "SELECT * FROM " . $this->table_name . " WHERE name = '$name'";
        $result = $this->conn->query($query);

        return $result->num_rows ? $result->fetch_assoc() : null;
    }
}