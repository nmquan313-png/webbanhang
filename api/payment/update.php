<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$orderId = $data['order_id'];
$status = $data['payment_status'];

$stmt = $db->prepare("
SELECT *
FROM orders
WHERE id=?
");

$stmt->execute([$orderId]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$order)
{
    echo json_encode([
        "success"=>false,
        "message"=>"Không tìm thấy đơn hàng"
    ]);
    exit();
}

if($order['payment_status']=='paid')
{
    echo json_encode([
        "success"=>false,
        "message"=>"Đơn hàng đã thanh toán"
    ]);
    exit();
}

$stmt = $db->prepare("
UPDATE orders
SET payment_status=?
WHERE id=?
");

$result = $stmt->execute([
    $status,
    $orderId
]);

echo json_encode([
    "success"=>$result
]);