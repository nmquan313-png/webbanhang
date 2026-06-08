<?php
session_start();
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new ProductModel($db);

// Kiểm tra giỏ hàng
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: index.php');
    exit();
}

// Tính tổng tiền
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $product = $productModel->getById((int)$id);
    if ($product && isset($product['price'])) {
        $price = (float)$product['price'];
        $total += $price * (int)$qty;
    }
}

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $customer_email = trim($_POST['customer_email']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_address = trim($_POST['customer_address']);
    
    // Validation
    if (empty($customer_name) || empty($customer_email) || empty($customer_phone) || empty($customer_address)) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } elseif ($total <= 0) {
        $error = "Tổng tiền không hợp lệ!";
    } else {
        try {
            $db->beginTransaction();
            
            // Insert vào bảng orders - đảm bảo total là số thực
            $query = "INSERT INTO orders (customer_name, customer_email, customer_phone, 
                      customer_address, total_amount, status) 
                      VALUES (?, ?, ?, ?, ?, 'pending')";
            $stmt = $db->prepare($query);
            $stmt->execute([
                $customer_name,
                $customer_email,
                $customer_phone,
                $customer_address,
                (float)$total  // Ép kiểu float để chắc chắn
            ]);
            
            $order_id = $db->lastInsertId();
            
            // Insert vào bảng order_details
            $query_detail = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                            VALUES (?, ?, ?, ?)";
            $stmt_detail = $db->prepare($query_detail);
            
            foreach ($_SESSION['cart'] as $id => $qty) {
                $product = $productModel->getById((int)$id);
                if ($product) {
                    $price = (float)$product['price'];
                    $stmt_detail->execute([
                        $order_id,
                        (int)$id,
                        (int)$qty,
                        $price
                    ]);
                }
            }
            
            $db->commit();
            
            // Xóa giỏ hàng
            unset($_SESSION['cart']);
            
            // Chuyển đến trang thành công
            header('Location: order-success.php?id=' . $order_id);
            exit();
            
        } catch (PDOException $e) {
            $db->rollBack();
            $error = "Lỗi đặt hàng: " . $e->getMessage();
        } catch (Exception $e) {
            $db->rollBack();
            $error = "Lỗi: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-mobile-alt"></i> ĐIỆN TỬ STORE
        </a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4"><i class="fas fa-credit-card"></i> Thanh toán</h2>
    
    <?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" class="form-control" 
                                   value="<?php echo isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="customer_email" class="form-control" 
                                   value="<?php echo isset($_POST['customer_email']) ? htmlspecialchars($_POST['customer_email']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="customer_phone" class="form-control" 
                                   value="<?php echo isset($_POST['customer_phone']) ? htmlspecialchars($_POST['customer_phone']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                            <textarea name="customer_address" class="form-control" rows="3" 
                                      required><?php echo isset($_POST['customer_address']) ? htmlspecialchars($_POST['customer_address']) : ''; ?></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle"></i> Xác nhận đặt hàng
                            </button>
                            <a href="index.php?controller=cart&action=index" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại giỏ hàng
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Đơn hàng của bạn</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>SL</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($_SESSION['cart'] as $id => $qty) {
                                $product = $productModel->getById((int)$id);
                                if ($product) {
                                    $price = (float)$product['price'];
                                    $subtotal = $price * (int)$qty;
                            ?>
                            <tr>
                                <td>
                                    <small><?php echo htmlspecialchars($product['name']); ?></small>
                                </td>
                                <td><?php echo (int)$qty; ?></td>
                                <td class="text-end">
                                    <small><?php echo number_format($subtotal, 0, ',', '.'); ?> ₫</small>
                                </td>
                            </tr>
                            <?php 
                                }
                            } 
                            ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="2" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td class="text-end">
                                    <strong class="text-danger fs-5"><?php echo number_format($total, 0, ',', '.'); ?> ₫</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p>&copy; 2026 Điện Tử Store. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>