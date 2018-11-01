<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'f37ee';
    private $username = 'f37ee';
    private $password = 'f37ee';
    
    private static $db;
    private $conn;

    private function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password);

        if ($this->conn->connect_errno) {
            die('Connection failed');
        }

        @$this->conn->select_db($this->db_name);
        $this->initialize();
    }

    private function initialize() {
        $query = "SHOW TABLES LIKE 'movie'";
        if($this->conn->query($query)->num_rows) {
            return;
        }
    }

    function __destruct() {
        $this->conn->close();
    }

    public static function getConnection() {
        if(self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->conn;
    }
}