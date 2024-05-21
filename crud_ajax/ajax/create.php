<?php
// ajax/create.php
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/Record.php';

$database = new Database();
$db = $database->getConnection();

$record = new Record($db);

$data = json_decode(file_get_contents("php://input"));

$record->name = $data->name;
$record->email = $data->email;

if ($record->create()) {
    echo json_encode(array("message" => "Record was created."));
} else {
    echo json_encode(array("message" => "Unable to create record."));
}
