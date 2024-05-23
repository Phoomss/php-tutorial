<?php
include_once 'config/database.php';
include_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->name = $_POST['name'];
$user->email = $_POST['email'];

if (!empty($_FILES['picture']['name'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        $user->picture = basename($_FILES["picture"]["name"]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Image upload failed']);
        exit;
    }
} else {
    $user->picture = $_POST['existing_picture'] ?? null;
}

if (empty($_POST['id'])) {
    // Create new user
    if ($user->create()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User creation failed']);
    }
} else {
    // Update existing user
    $user->id = $_POST['id'];
    if ($user->update()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User update failed']);
    }
}
?>
