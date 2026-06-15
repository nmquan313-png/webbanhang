<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

if($_SERVER['REQUEST_METHOD'] != 'PUT')
{
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit();
}

$data = json_decode(
    file_get_contents("php://input"),
    true
);

/*
|--------------------------------------------------------------------------
| Validate tên
|--------------------------------------------------------------------------
*/
if(empty(trim($data['name'] ?? '')))
{
    echo json_encode([
        "success" => false,
        "message" => "Tên sản phẩm không được để trống"
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate giá
|--------------------------------------------------------------------------
*/
if(
    !is_numeric($data['price'] ?? 0)
    ||
    $data['price'] <= 0
)
{
    echo json_encode([
        "success" => false,
        "message" => "Giá phải lớn hơn 0"
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate danh mục
|--------------------------------------------------------------------------
*/
$stmt = $db->prepare(
    "SELECT id FROM categories WHERE id=?"
);

$stmt->execute([
    $data['category_id'] ?? 0
]);

if($stmt->rowCount() == 0)
{
    echo json_encode([
        "success" => false,
        "message" => "Danh mục không hợp lệ"
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate ảnh
|--------------------------------------------------------------------------
*/
if(!empty($data['image']))
{
    $ext = strtolower(
        pathinfo(
            $data['image'],
            PATHINFO_EXTENSION
        )
    );

    $allow = [
        'jpg',
        'jpeg',
        'png',
        'gif',
        'webp'
    ];

    if(!in_array($ext, $allow))
    {
        echo json_encode([
            "success" => false,
            "message" => "Định dạng ảnh không hợp lệ"
        ]);
        exit();
    }
}

/*
|--------------------------------------------------------------------------
| Update
|--------------------------------------------------------------------------
*/
$result = $productModel->update(
    $data['id'],
    $data['category_id'],
    $data['name'],
    $data['description'] ?? '',
    $data['price'],
    $data['image'] ?? '',
    $data['quantity'] ?? 0
);

echo json_encode([
    "success" => $result,
    "message" => $result
        ? "Cập nhật thành công"
        : "Cập nhật thất bại"
]);