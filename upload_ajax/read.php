<?php
include_once 'config/database.php';
include_once 'classes/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

if (isset($_GET['id'])) {
    $user->id = $_GET['id'];
    $user->readOne();
    echo json_encode([
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "picture" => $user->picture
    ]);
} else {
    $stmt = $user->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $users_arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $user_item = [
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "picture" => $picture
            ];
            array_push($users_arr, $user_item);
        }
        echo json_encode($users_arr);
    } else {
        echo json_encode([]);
    }
}
