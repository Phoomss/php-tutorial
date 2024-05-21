<?php
// ajax/register.php
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$password = password_hash($data->password, PASSWORD_BCRYPT);
$role = $data->role;

// Check if username already exists
$query = "SELECT id FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode(array("message" => "Username already exists."));
} else {
    // Insert new user into the database
    $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Registration successful."));
    } else {
        echo json_encode(array("message" => "Registration failed."));
    }
}
