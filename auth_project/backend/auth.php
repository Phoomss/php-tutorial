<?php
function checkUserRole($role)
{
    if (!isset($_SESSION['userInfo']) || $_SESSION['userInfo']['role'] !== $role) {
        header("Location: ../login.php");
        exit();
    }
}
?>
