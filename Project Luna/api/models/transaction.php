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
            (name, email, combo_a, combo_b, `timestamp`) VALUES (:name, :email, :combo_a, :combo_b, :timestamp);
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':combo_a', $this->combo_a);
        $stmt->bindParam(':combo_b', $this->combo_b);
        $stmt->bindParam(':timestamp', $this->timestamp);
        $stmt->execute();
        return $stmt;
    }
}