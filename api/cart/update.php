<?php

session_start();

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] != 'PUT')
{
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit();
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$id = $data['product_id'] ?? 0;
$qty = $data['quantity'] ?? 0;

if($qty <= 0)
{
    echo json_encode([
        "success" => false,
        "message" => "Số lượng phải lớn hơn 0"
    ]);
    exit();
}

if(!isset($_SESSION['cart'][$id]))
{
    echo json_encode([
        "success" => false,
        "message" => "Sản phẩm không tồn tại trong giỏ hàng"
    ]);
    exit();
}

$_SESSION['cart'][$id] = $qty;

echo json_encode([
    "success" => true,
    "message" => "Cập nhật giỏ hàng thành công"
]);

?>