<?php
class DefaultController {
    protected $productModel;
    protected $categoryModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
        $this->categoryModel = new CategoryModel($db);
    }

    public function index() {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        // ✅ Sửa đường dẫn view
        include APP_PATH . '/views/product/list.php';
    }
}
?>