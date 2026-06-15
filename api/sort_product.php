<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

$db = (new Database())->getConnection();

$productModel = new ProductModel($db);

$order = $_GET['order'] ?? 'ASC';

if($order!='ASC' && $order!='DESC')
{
    $order='ASC';
}

$data = $productModel->sortByPrice($order);

header('Content-Type: application/json');

echo json_encode($data);