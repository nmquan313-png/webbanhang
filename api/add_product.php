<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$data = json_decode(file_get_contents("php://input"), true);

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$result = $productModel->create(
    $data['category_id'],
    $data['name'],
    $data['description'],
    $data['price'],
    $data['image'],
    $data['quantity']
);

header('Content-Type: application/json');

echo json_encode([
    'success' => $result
]);