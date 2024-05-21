<?php
header('Content-Type: application/json');  // ระบุประเภทเนื้อหาเป็น JSON
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/User.php';

// เริ่มต้น session ถ้ายังไม่ได้เริ่ม
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$password = $data->password;

$query = "SELECT id, username, password, role FROM users WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();

$response = array();  // สร้างตัวแปรสำหรับเก็บข้อมูลการตอบกลับ

if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $response["message"] = "Login successful.";
    } else {
        $response["message"] = "Invalid username or password.";
    }
} else {
    $response["message"] = "Invalid username or password.";
}

echo json_encode($response);  // ส่งข้อมูลกลับในรูปแบบ JSON
?>
