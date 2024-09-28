<?php
include_once '../config/database.php';
include_once '../backend/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->username = $_POST['username'];
$user->email = $_POST['email'];
$user->password = $_POST['password'];

if($user->register()) {
    echo "Registration successful!";
} else {
    echo "Registration failed!";
}
?>
