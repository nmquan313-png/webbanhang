<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$db = (new Database())->getConnection();

$productModel = new ProductModel($db);

$keyword = $_GET['keyword'] ?? '';

$data = $productModel->searchByName($keyword);

header('Content-Type: application/json');

echo json_encode($data);