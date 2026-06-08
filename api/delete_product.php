<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$result = $productModel->delete($id);

header('Content-Type: application/json');

echo json_encode([
    'success' => $result
]);