<?php
// ajax/delete.php
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/Record.php';

$database = new Database();
$db = $database->getConnection();

$record = new Record($db);

$data = json_decode(file_get_contents("php://input"));

$record->id = $data->id;

if ($record->delete()) {
    echo json_encode(array("message" => "Record was deleted."));
} else {
    echo json_encode(array("message" => "Unable to delete record."));
}
