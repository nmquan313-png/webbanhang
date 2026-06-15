<?php

require_once '../app/config/database.php';
require_once '../app/models/CategoryModel.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$model = new CategoryModel($db);

$data = json_decode(
    file_get_contents("php://input"),
    true
);

if(empty(trim($data['name'] ?? '')))
{
    echo json_encode([
        "success"=>false,
        "message"=>"Tên danh mục không được rỗng"
    ]);
    exit();
}

$result = $model->update(
    $data['id'],
    $data['name']
);

echo json_encode([
    "success"=>$result
]);