<?php
header('Content-Type: application/json');  // ระบุประเภทเนื้อหาเป็น JSON
require_once '../config.php';
require_once '../classes/User.php';

// เริ่ม session หากยังไม่ได้เริ่ม
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (User::isLoggedIn()) {
    echo json_encode(array("logged_in" => true, "username" => $_SESSION['username'], "role" => $_SESSION['role']));
} else {
    echo json_encode(array("logged_in" => false));
}
