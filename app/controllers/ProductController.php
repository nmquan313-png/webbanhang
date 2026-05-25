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
        $products = $this->productModel->getAll();
        // ✅ Sửa đường dẫn: dùng APP_PATH
        include APP_PATH . '/views/product/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category_id = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $image = $this->uploadImage();
            
            if ($this->productModel->create($category_id, $name, $description, $price, $image, $quantity)) {
                header('Location: index.php?controller=product&action=list');
                exit();
            }
        }
        $categories = $this->categoryModel->getAll();
        include APP_PATH . '/views/product/add.php'; // ✅ Sửa ở đây
    }

    // ... các hàm edit, delete, detail cũng sửa tương tự ...
    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $category_id = $_POST['category_id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];
            $product = $this->productModel->getById($id);
            $image = $product['image'];
            if (!empty($_FILES['image']['name'])) {
                $image = $this->uploadImage();
            }
            if ($this->productModel->update($id, $category_id, $name, $description, $price, $image, $quantity)) {
                header('Location: index.php?controller=product&action=list');
                exit();
            }
        }
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();
        include APP_PATH . '/views/product/edit.php'; // ✅ Sửa ở đây
    }

    public function delete() {
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

    public function detail() {
        $id = $_GET['id'];
        $product = $this->productModel->getById($id);
        include APP_PATH . '/views/product/detail.php'; // ✅ Sửa ở đây
    }

    public function addToCart() {
        $id = $_POST['product_id'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }
        header('Location: index.php?controller=cart&action=index');
        exit();
    }
}
?>