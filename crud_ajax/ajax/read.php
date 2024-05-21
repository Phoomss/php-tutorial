<?php
// ajax/read.php
require_once '../config.php';
require_once '../classes/Database.php';
require_once '../classes/Record.php';

$database = new Database();
$db = $database->getConnection();

$record = new Record($db);

$stmt = $record->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $records_arr = array();
    $records_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $record_item = array(
            "id" => $id,
            "name" => $name,
            "email" => $email
        );
        array_push($records_arr["records"], $record_item);
    }

    echo json_encode($records_arr);
} else {
    echo json_encode(array("message" => "No records found."));
}
