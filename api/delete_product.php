<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

if($_SERVER['REQUEST_METHOD'] != 'DELETE')
{
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit();
}

$id = $_GET['id'] ?? 0;

$result = $productModel->delete($id);

echo json_encode([
    "success" => $result
]);