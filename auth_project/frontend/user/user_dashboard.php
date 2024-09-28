<?php
session_start();

// รวมไฟล์ auth.php ที่มีฟังก์ชัน checkUserRole()
require_once '../../backend/auth.php';

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['userInfo'])) {
    header("Location: ../login.php");
    exit();
}

// ตรวจสอบการเข้าถึงของ admin
checkUserRole('user');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
        <a href="#" onclick="confirmLogout()">Logout</a>
            <a class="navbar-brand" href="#">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome, User <?php echo $_SESSION['userInfo']['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
                        Dashboard
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">Manage Users</a>
                    <a href="#" class="list-group-item list-group-item-action">Settings</a>
                </div>
            </div>
            <div class="col-lg-9">
                <h1 class="display-6">User Dashboard</h1>
                <p>Welcome to the User dashboard. You can manage users, settings, and view reports here.</p>
                <div class="card mt-4">
                    <div class="card-header">
                        Recent Activities
                    </div>
                    <div class="card-body">
                        <p class="card-text">Here you can view the recent activities...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function confirmLogout() {
            if (confirm("คุณแน่ใจหรือว่าต้องการออกจากระบบ?")) {
                window.location.href = "../../backend/logout.php";   // เปลี่ยนเส้นทางไปยัง logout.php
            }
        }
    </script>

</body>

</html>