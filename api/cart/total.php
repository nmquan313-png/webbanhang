<?php

session_start();

require_once '../../app/config/database.php';
require_once '../../app/models/ProductModel.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$productModel = new ProductModel($db);

$total = 0;

if(isset($_SESSION['cart']))
{
    foreach($_SESSION['cart'] as $id => $qty)
    {
        $product = $productModel->getById($id);

        if($product)
        {
            $total +=
                $product['price']
                *
                $qty;
        }
    }
}

echo json_encode([
    "success"=>true,
    "total"=>$total
]);