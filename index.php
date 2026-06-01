<?php
// Router chính
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path để include file cho đúng
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');

// Include database config
require_once APP_PATH . '/config/database.php';

// Include models
require_once APP_PATH . '/models/CategoryModel.php';
require_once APP_PATH . '/models/ProductModel.php';
require_once APP_PATH . '/models/UserModel.php';

// Include controllers
require_once APP_PATH . '/controllers/DefaultController.php';
require_once APP_PATH . '/controllers/CategoryController.php';
require_once APP_PATH . '/controllers/ProductController.php';
require_once APP_PATH . '/controllers/CartController.php'; // Thêm controller giỏ hàng
require_once APP_PATH . '/controllers/UserController.php';

// Get database connection
try {
    $database = new Database();
    $db = $database->getConnection();
} catch (Exception $e) {
    echo "Database Connection Error: " . $e->getMessage();
    exit();
}

// Router
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'default';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Xử lý Router
switch($controller) {
    
    // --- CATEGORY CONTROLLER ---
    case 'category':
        $categoryController = new CategoryController($db);
        switch($action) {
            case 'list':
                $categoryController->list();
                break;
            case 'add':
                $categoryController->add();
                break;
            case 'edit':
                $categoryController->edit();
                break;
            case 'delete':
                $categoryController->delete();
                break;
            default:
                $categoryController->list();
                break;
        }
        break;
        
    // --- PRODUCT CONTROLLER ---
    case 'product':
        $productController = new ProductController($db);
        switch($action) {
            case 'list':
                $productController->list();
                break;
            case 'add':
                $productController->add();
                break;
            case 'edit':
                $productController->edit();
                break;
            case 'delete':
                $productController->delete();
                break;
            case 'addToCart':
                $productController->addToCart();
                break;
            case 'detail':
                    $productController->detail();
                    break;
            default:
                $productController->list();
                break;
        }
        break;
        
    // --- CART CONTROLLER ---
    case 'cart':
        $cartController = new CartController($db);
        switch($action) {
            case 'index':
                $cartController->index();
                break;
            case 'remove':
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    if(isset($_SESSION['cart'][$id])) {
                        unset($_SESSION['cart'][$id]);
                    }
                }
                header('Location: index.php?controller=cart&action=index');
                exit();
            case 'clear':
                unset($_SESSION['cart']);
                header('Location: index.php?controller=cart&action=index');
                exit();
            default:
                $cartController->index();
                break;
        }
        break;

        case 'user':

        
            $userController = new UserController();
        
            switch($action){
        
                case 'login':
                    $userController->login();
                    break;
        
                case 'register':
                    $userController->register();
                    break;
        
                case 'logout':
                    $userController->logout();
                    break;
        
                default:
                    $userController->login();
                    break;
            }
        
            break;

    // --- DEFAULT CONTROLLER (TRANG CHỦ) ---
    default:
        $defaultController = new DefaultController($db);
        $defaultController->index();
        break;
}
// Kết thúc switch
?>