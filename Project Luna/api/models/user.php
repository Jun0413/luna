<?php
require_once 'base.php';
class User extends Base {
    protected $table_name = 'user';

    public $name;
    public $email;
    public $password;

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
            (name, email, password) VALUES (?, ?, ?);
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $this->name, $this->email, $this->password);
        $stmt->execute();
        return $stmt;
    }
}