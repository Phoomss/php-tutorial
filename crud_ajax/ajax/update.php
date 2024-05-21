<?php
// ajax/update.php
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/Record.php';

$database = new Database();
$db = $database->getConnection();

$record = new Record($db);

$data = json_decode(file_get_contents("php://input"));

$record->id = $data->id;
$record->name = $data->name;
$record->email = $data->email;

if ($record->update()) {
    echo json_encode(array("message" => "Record was updated."));
} else {
    echo json_encode(array("message" => "Unable to update record."));
}
