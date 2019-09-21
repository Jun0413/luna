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
        $query = file_get_contents(dirname(__DIR__).'/../libs/sql/init.sql');
        $query .= file_get_contents(dirname(__DIR__).'/../libs/sql/data.sql');
        $query = str_replace('DB_NAME', $this->db_name, $query);
        $this->conn->multi_query($query);
    }
    
    function __destruct() {
        $this->conn->close();
    }
    
    public static function getConnection() {
        if(is_null(self::$db)) {
            self::$db = new Database();
        }
        return self::$db->conn;
    }
}