<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = $productModel->getById($id);

header('Content-Type: application/json');

if (!$product) {

    echo json_encode([
        "success" => false,
        "message" => "Không tìm thấy sản phẩm"
    ]);

    exit();
}

echo json_encode([
    "success" => true,
    "data" => $product
]);