<?php
// index.php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Welcome to User Management System</h1>
        <p class="lead">This is a simple user management system using PHP, OOP, and PDO.</p>
        
        <div class="mt-4">
            <?php if(isset($_SESSION['user'])): ?>
                <p>Welcome, <?php echo $_SESSION['user']['username']; ?>!</p>
                <a href="public/update_role.php" class="btn btn-info">Update Role</a>
                <a href="public/logout.php" class="btn btn-danger">Logout</a>
            <?php else: ?>
                <a href="public/register.php" class="btn btn-primary">Register</a>
                <a href="public/login.php" class="btn btn-success">Login</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
