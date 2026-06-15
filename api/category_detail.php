<?php

require_once '../app/config/database.php';
require_once '../app/models/CategoryModel.php';

$db = (new Database())->getConnection();

$model = new CategoryModel($db);

$id = $_GET['id'] ?? 0;

$data = $model->getById($id);

echo json_encode([
    "success"=>true,
    "data"=>$data
]);