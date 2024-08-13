<?php

require_once '../config/Database.php';
require_once '../backend/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    $loggedInUser = $user->login();

    if ($loggedInUser) {
        session_start();
        $_SESSION['user'] = $loggedInUser;

        // ตรวจสอบบทบาทผู้ใช้
        if ($loggedInUser['role'] == 'admin') {
            header("Location: ../admin.php");  // ไปยังหน้า Admin
        } else {
            header("Location: ../user.php");   // ไปยังหน้า User
        }
        exit();
    } else {
        echo "<p class='alert alert-danger'>Login failed. Invalid email or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Login</button>
        </form>
    </div>
</body>

</html>