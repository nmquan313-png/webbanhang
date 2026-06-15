<?php

session_start();

require_once '../../app/config/database.php';
require_once '../../app/models/ProductModel.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();
$productModel = new ProductModel($db);

if(empty($_SESSION['cart']))
{
    echo json_encode([
        "success"=>false,
        "message"=>"Giỏ hàng trống"
    ]);
    exit();
}

$total = 0;

foreach($_SESSION['cart'] as $id=>$qty)
{
    $product = $productModel->getById($id);

    $total += $product['price'] * $qty;
}

$stmt = $db->prepare("
INSERT INTO orders
(
customer_name,
customer_email,
customer_phone,
customer_address,
total_amount,
status
)
VALUES(?,?,?,?,?,?)
");

$stmt->execute([
    $_POST['customer_name'],
    $_POST['customer_email'],
    $_POST['customer_phone'],
    $_POST['customer_address'],
    $total,
    'pending'
]);

$orderId = $db->lastInsertId();

foreach($_SESSION['cart'] as $id=>$qty)
{
    $product = $productModel->getById($id);

    $stmt = $db->prepare("
    INSERT INTO order_details
    (
    order_id,
    product_id,
    quantity,
    price
    )
    VALUES(?,?,?,?)
    ");

    $stmt->execute([
        $orderId,
        $id,
        $qty,
        $product['price']
    ]);
}

unset($_SESSION['cart']);

echo json_encode([
    "success"=>true,
    "order_id"=>$orderId
]);