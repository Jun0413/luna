<?php
require_once 'base.php';
class Transaction extends Base {
    protected $table_name = 'transaction';

    public $name;
    public $email;
    public $combo_a;
    public $combo_b;
    public $timestamp;

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
            (name, email, combo_a, combo_b, `timestamp`) VALUES (?, ?, ?, ?, ?);
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssiis', $this->name, $this->email, $this->combo_a, $this->combo_b, $this->timestamp);
        $stmt->execute();
        return $stmt;
    }
}