<?php
// app/controllers/CartController.php

class CartController {
    protected $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        if(!isset($_SESSION['user']))
        {
            header("Location: index.php?controller=user&action=login");
            exit();
        }
        $productModel = $this->productModel;
        // ✅ Dùng APP_PATH cho thống nhất
        include APP_PATH . '/views/product/viewcart.php';
    }
}
?>