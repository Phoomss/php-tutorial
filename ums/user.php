<?php
session_start();

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบแล้วหรือไม่และมีบทบาทเป็น user
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'user') {
    header("Location: public/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-5">User Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION['user']['username']; ?>! You are logged in as a user.</p>
        <a href="public/logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>

</html>