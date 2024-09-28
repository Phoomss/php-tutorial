<?php
include_once '../config/database.php';
include_once '../backend/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = $_POST['email'];
$user->password = $_POST['password'];

if($user_data = $user->login()) {
    echo "Login successful! Welcome " . $user_data['username'];
} else {
    echo "Login failed! Incorrect email or password.";
}
?>
