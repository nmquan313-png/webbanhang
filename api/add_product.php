<?php

require_once '../app/config/database.php';
require_once '../app/models/ProductModel.php';

header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();

$productModel = new ProductModel($db);

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed"
    ]);
    exit();
}

/*
|--------------------------------------------------------------------------
| Validate tên sản phẩm
|--------------------------------------------------------------------------
*/
if(empty(trim($_POST['name'])))
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
    !is_numeric($_POST['price'])
    ||
    $_POST['price'] <= 0
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
| Upload & Validate ảnh
|--------------------------------------------------------------------------
*/
$imageName = '';

if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
{
    $ext = strtolower(
        pathinfo(
            $_FILES['image']['name'],
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

    $imageName =
        time().'_'.
        $_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../public/images/'.$imageName
    );
}

/*
|--------------------------------------------------------------------------
| Thêm sản phẩm
|--------------------------------------------------------------------------
*/
$result = $productModel->create(
    $_POST['category_id'],
    $_POST['name'],
    $_POST['description'],
    $_POST['price'],
    $imageName,
    $_POST['quantity']
);

echo json_encode([
    "success" => $result,
    "message" => $result
        ? "Thêm sản phẩm thành công"
        : "Thêm sản phẩm thất bại"
]);