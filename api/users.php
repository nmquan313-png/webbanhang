<?php

require_once '../app/config/database.php';

$database = new Database();
$db = $database->getConnection();

$stmt = $db->prepare("
    SELECT id, fullname, email, role
    FROM users
");

$stmt->execute();

$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row;
}

header('Content-Type: application/json');

echo json_encode($data);