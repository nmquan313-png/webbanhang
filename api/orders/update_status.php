<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$data = json_decode(
file_get_contents("php://input"),
true
);

$stmt = $db->prepare("
UPDATE orders
SET status=?
WHERE id=?
");

$result = $stmt->execute([
$data['status'],
$data['id']
]);

echo json_encode([
"success"=>$result
]);