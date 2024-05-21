<?php
// ajax/logout.php
require_once '../config.php';
require_once '../classes/User.php';

User::logout();
echo json_encode(array("message" => "Logout successful."));
