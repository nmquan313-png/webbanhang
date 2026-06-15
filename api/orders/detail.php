<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$id = $_GET['id'];

$stmt = $db->prepare("
SELECT *
FROM orders
WHERE id=?
");

$stmt->execute([$id]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
SELECT od.*,p.name
FROM order_details od
LEFT JOIN products p
ON od.product_id=p.id
WHERE od.order_id=?
");

$stmt->execute([$id]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "order"=>$order,
    "items"=>$items
]);