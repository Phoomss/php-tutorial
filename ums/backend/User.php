<?php
require_once '../config/Database.php';

class User
{
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $password;
    public $email;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Register a new user
    public function register()
    {
        $query = "INSERT INTO $this->table (username, password, email, role) VALUES (:username, :password, :email, :role)";

        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // Hash password
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->role = htmlspecialchars(strip_tags($this->role));

        // Bind data
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':role', $this->role);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Login user
    public function login()
    {
        $query = "SELECT * FROM $this->table WHERE email = :email";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':email', $this->email);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Get user by ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
