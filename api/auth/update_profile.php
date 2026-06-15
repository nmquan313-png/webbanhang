<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$stmt = $db->prepare("
UPDATE users
SET fullname=?
WHERE id=?
");

$result = $stmt->execute([
    $data['fullname'],
    $data['id']
]);

echo json_encode([
    "success"=>$result
]);