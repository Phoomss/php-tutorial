<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class User
{
    private $conn;
    private $table_name = "users";

    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function register()
    {
        // ตรวจสอบว่า role ถูกกำหนดแล้วหรือไม่
        if (empty($this->role)) {
            $this->role = 'user'; // กำหนดค่าเริ่มต้นให้เป็น 'user' หากไม่ได้รับจาก input
        }

        $query = "INSERT INTO " . $this->table_name . " (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // เข้ารหัสรหัสผ่าน
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        // ผูกค่าตัวแปร
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":role", $this->role);

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
            $_SESSION['userInfo'] = $user;
            return true;
        }

        return false;
    }
}
