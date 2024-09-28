<?php
session_start();

// ทำลายเซสชันทั้งหมด
$_SESSION = []; // เคลียร์ข้อมูลในเซสชัน
session_destroy(); // ทำลายเซสชัน

// เปลี่ยนเส้นทางไปยังหน้าหลักหรือหน้าเข้าสู่ระบบ
header("Location: ../login.php");
exit();
?>
