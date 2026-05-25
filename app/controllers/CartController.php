<?php
// app/controllers/CartController.php

class CartController {
    protected $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        $productModel = $this->productModel;
        // ✅ Dùng APP_PATH cho thống nhất
        include APP_PATH . '/views/product/viewcart.php';
    }
}
?>