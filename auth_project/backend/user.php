<?php
session_start();
class User
{
    private $conn;
    private $table_name = "users";

    public $username;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register()
    {
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // ทำการเข้ารหัสรหัสผ่าน
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // ผูกค่าตัวแปร
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function login()
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($this->password, $user['password'])) {
            // เก็บค่าใน session
            $_SESSION['userInfo'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email']
            ];
            return $user;
        }
    
        return false;
    }
    
}
