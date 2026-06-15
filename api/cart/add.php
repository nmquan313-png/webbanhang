<?php

session_start();

require_once '../../app/config/database.php';
require_once '../../app/models/ProductModel.php';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$id = $_POST['product_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

if($quantity <= 0)
{
    echo json_encode([
        "success" => false,
        "message" => "Số lượng phải lớn hơn 0"
    ]);
    exit();
}

$product = $productModel->getById($id);

if(!$product)
{
    echo json_encode([
        "success" => false,
        "message" => "Sản phẩm không tồn tại"
    ]);
    exit();
}

if(isset($_SESSION['cart'][$id]))
{
    $_SESSION['cart'][$id] += $quantity;
}
else
{
    $_SESSION['cart'][$id] = $quantity;
}

echo json_encode([
    "success" => true,
    "message" => "Đã thêm vào giỏ hàng"
]);

?>