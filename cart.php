<?php
session_start();
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new ProductModel($db);

// Xử lý thêm vào giỏ hàng
if (isset($_POST['add_to_cart']) || isset($_GET['add'])) {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : (int)$_GET['add'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if ($quantity < 1) {
        $quantity = 1;
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    
    header('Location: cart.php');
    exit();
}

// Xử lý xóa
if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
    exit();
}

// Xử lý cập nhật
if (isset($_POST['update_cart'])) {
    if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $id => $qty) {
            $id = (int)$id;
            $qty = (int)$qty;
            if ($qty > 0) {
                $_SESSION['cart'][$id] = $qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    header('Location: cart.php');
    exit();
}

// Xóa toàn bộ giỏ hàng
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header('Location: cart.php');
    exit();
}

// Tính tổng tiền
$total = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-mobile-alt"></i> ĐIỆN TỬ STORE
        </a>
        <a href="cart.php" class="btn btn-outline-light">
            <i class="fas fa-shopping-cart"></i> Giỏ hàng
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <span class="badge bg-danger"><?php echo count($_SESSION['cart']); ?></span>
            <?php endif; ?>
        </a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h2>
    
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
    <form method="POST" action="cart.php">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($_SESSION['cart'] as $id => $qty) {
                        $id = (int)$id;
                        $qty = (int)$qty;
                        
                        $product = $productModel->getById($id);
                        
                        if ($product && isset($product['price'])) {
                            $price = (float)$product['price'];
                            $subtotal = $price * $qty;
                            $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <?php if (!empty($product['image'])): ?>
                                <img src="public/images/<?php echo htmlspecialchars($product['image']); ?>" 
                                     width="80" alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     class="img-thumbnail">
                            <?php else: ?>
                                <img src="public/images/no-image.jpg" width="80" alt="No image" class="img-thumbnail">
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong>
                            <?php if (isset($product['category_name'])): ?>
                                <br><small class="text-muted"><?php echo htmlspecialchars($product['category_name']); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo number_format($price, 0, ',', '.'); ?> ₫</td>
                        <td>
                            <input type="number" name="quantity[<?php echo $id; ?>]" 
                                   value="<?php echo $qty; ?>" min="1" max="99" 
                                   class="form-control" style="width: 80px;">
                        </td>
                        <td class="text-danger fw-bold">
                            <?php echo number_format($subtotal, 0, ',', '.'); ?> ₫
                        </td>
                        <td>
                            <a href="cart.php?remove=<?php echo $id; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        </td>
                    </tr>
                    <?php 
                        }
                    } 
                    ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td colspan="2" class="text-danger fw-bold fs-5">
                            <?php echo number_format($total, 0, ',', '.'); ?> ₫
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <button type="submit" name="update_cart" class="btn btn-warning">
                    <i class="fas fa-sync"></i> Cập nhật giỏ hàng
                </button>
                <a href="cart.php?clear=1" class="btn btn-danger" 
                   onclick="return confirm('Xóa toàn bộ giỏ hàng?')">
                    <i class="fas fa-trash"></i> Xóa tất cả
                </a>
            </div>
            <div class="col-md-6 text-end">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Tiếp tục mua
                </a>
                <a href="checkout.php" class="btn btn-success btn-lg">
                    <i class="fas fa-credit-card"></i> Thanh toán ngay
                </a>
            </div>
        </div>
    </form>
    <?php else: ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
        <h4>Giỏ hàng của bạn đang trống</h4>
        <p>Hãy tiếp tục mua sắm để thêm sản phẩm vào giỏ hàng!</p>
        <a href="index.php" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-store"></i> Đến cửa hàng
        </a>
    </div>
    <?php endif; ?>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p>&copy; 2026 Điện Tử Store. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>