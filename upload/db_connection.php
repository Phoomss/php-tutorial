<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'upload_php'; // Replace with your database name
    private $username = 'root'; // Replace with your database username
    private $password = ''; // Replace with your database password
    public $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }
}
?>
