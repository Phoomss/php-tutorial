<?php
session_start();
include_once '../config/database.php';
include_once '../backend/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$response = [
    "status" => "error",
    "message" => "Invalid email or password"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        $role = $_SESSION['userInfo']['role'];
        $response = [
            "status" => "success",
            "role" => $role
        ];
    }
}

echo json_encode($response);
?>
