<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$stmt = $db->query("
SELECT *
FROM orders
ORDER BY id DESC
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);