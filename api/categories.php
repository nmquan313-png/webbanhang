<?php

require_once '../app/config/database.php';
require_once '../app/models/CategoryModel.php';

$database = new Database();
$db = $database->getConnection();

$categoryModel = new CategoryModel($db);

$categories = $categoryModel->getAll();

$data = [];

while($row = $categories->fetch(PDO::FETCH_ASSOC)){
    $data[] = $row;
}

header('Content-Type: application/json');

echo json_encode($data);