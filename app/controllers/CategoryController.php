<?php
class CategoryController {
    private $model;

    public function __construct($db) {
        $this->model = new CategoryModel($db);
    }

    public function list() {
        $categories = $this->model->getAll();
        include APP_PATH . '/views/category/list.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if ($this->model->create($name)) {
                header('Location: index.php?controller=category&action=list');
                exit();
            }
        }
        include APP_PATH . '/views/category/add.php';
    }

    public function edit() {
        $id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if ($this->model->update($id, $name)) {
                header('Location: index.php?controller=category&action=list');
                exit();
            }
        }
        
        $category = $this->model->getById($id);
        include APP_PATH . '/views/category/add.php';
    }

    public function delete() {
        $id = $_GET['id'];
        $this->model->delete($id);
        header('Location: index.php?controller=category&action=list');
        exit();
    }
}
?>