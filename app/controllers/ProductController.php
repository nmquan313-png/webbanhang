<?php
// app/controllers/ProductController.php

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
        $this->categoryModel = new CategoryModel($db);
    }

    public function list() {
        include APP_PATH.'/views/product/list.php';
    }

    public function add() {
        if(
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role']!='admin'
        ){
            die("Bạn không có quyền truy cập");
        }
        $categories = $this->categoryModel->getAll();
        include APP_PATH . '/views/product/add.php'; // ✅ Sửa ở đây
    }

    // ... các hàm edit, delete, detail cũng sửa tương tự ...
    public function edit() {
        if(
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role']!='admin'
        ){
            die("Bạn không có quyền truy cập");
        }
        $id = $_GET['id'];
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        include APP_PATH . '/views/product/edit.php'; // ✅ Sửa ở đây
    }

    public function delete() {
        if(
            !isset($_SESSION['user']) ||
            $_SESSION['user']['role']!='admin'
        ){
            die("Bạn không có quyền truy cập");
        }
        $id = $_GET['id'];
        $this->productModel->delete($id);
        header('Location: index.php?controller=product&action=list');
        exit();
    }

    private function uploadImage() {
        $target_dir = "public/images/";
        $image = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        return $image;
    }

    public function detail(){

    include APP_PATH.'/views/product/detail.php';
}

public function addToCart(){
    if(!isset($_SESSION['user']))
    {
        echo "<script>
                alert('Vui lòng đăng nhập trước khi thêm vào giỏ hàng');
                window.location='index.php?controller=user&action=login';
              </script>";
        exit();
    }

    $id = $_POST['product_id'];

    if(isset($_SESSION['cart'][$id]))
    {
        $_SESSION['cart'][$id]++;
    }
    else
    {
        $_SESSION['cart'][$id] = 1;
    }

    header("Location: index.php?controller=cart&action=index");
    exit();
}

public function searchByName($keyword)
{
    $stmt = $this->conn->prepare(
        "SELECT p.*, c.name as category_name
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         WHERE p.name LIKE ?"
    );

    $keyword = "%".$keyword."%";

    $stmt->execute([$keyword]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>