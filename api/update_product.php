<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$data = json_decode(file_get_contents("php://input"), true);

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$product = $productModel->getById($data['id']);

$result = $productModel->update(
    $data['id'],
    $product['category_id'],
    $data['name'],
    $product['description'],
    $data['price'],
    $product['image'],
    $product['quantity']
);

header('Content-Type: application/json');

echo json_encode([
    'success' => $result
]);