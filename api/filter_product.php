<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$db = (new Database())->getConnection();

$productModel = new ProductModel($db);

$category_id = $_GET['category_id'] ?? 0;

$data = $productModel->getByCategory($category_id);

header('Content-Type: application/json');

echo json_encode($data);