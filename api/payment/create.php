<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo json_encode([
        "success"=>false,
        "message"=>"Method not allowed"
    ]);
    exit();
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$orderId = $data['order_id'];
$method = $data['method'];

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
        "message"=>"Đơn hàng không tồn tại"
    ]);
    exit();
}

if($order['payment_status'] == 'paid')
{
    echo json_encode([
        "success"=>false,
        "message"=>"Đơn hàng đã thanh toán"
    ]);
    exit();
}

$status = 'unpaid';

if($method == 'BANKING')
{
    $status = 'paid';
}

$stmt = $db->prepare("
UPDATE orders
SET payment_method=?,
payment_status=?
WHERE id=?
");

$result = $stmt->execute([
    $method,
    $status,
    $orderId
]);

echo json_encode([
    "success"=>$result,
    "message"=>"Tạo thanh toán thành công"
]);