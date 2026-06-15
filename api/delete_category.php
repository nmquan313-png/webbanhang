<?php

require_once '../app/config/database.php';
require_once '../app/models/CategoryModel.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$model = new CategoryModel($db);

$id = $_GET['id'] ?? 0;

/*
|------------------------------------
| Kiểm tra còn sản phẩm không
|------------------------------------
*/

$stmt = $db->prepare(
    "SELECT COUNT(*) total
     FROM products
     WHERE category_id=?"
);

$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if($row['total'] > 0)
{
    echo json_encode([
        "success"=>false,
        "message"=>"Danh mục vẫn còn sản phẩm"
    ]);
    exit();
}

$result = $model->delete($id);

echo json_encode([
    "success"=>$result
]);