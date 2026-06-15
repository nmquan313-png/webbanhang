<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$id = $_GET['id'];

$stmt = $db->prepare("
UPDATE orders
SET status='cancelled'
WHERE id=?
");

$result = $stmt->execute([$id]);

echo json_encode([
    "success"=>$result
]);