<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$id = $_GET['id'];

$stmt = $db->prepare("
SELECT
id,
total_amount,
payment_method,
payment_status
FROM orders
WHERE id=?
");

$stmt->execute([$id]);

echo json_encode(
    $stmt->fetch(PDO::FETCH_ASSOC)
);