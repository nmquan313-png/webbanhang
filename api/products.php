<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

$products = $productModel->getAll();

$data = [];

while($row = $products->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row;
}

header('Content-Type: application/json');

echo json_encode($data);