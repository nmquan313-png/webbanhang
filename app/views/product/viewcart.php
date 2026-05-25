<?php
// app/views/product/viewcart.php

// KHÔNG require Model ở đây. Index.php đã load rồi.
// Controller sẽ truyền biến $productModel sang đây.

$total = 0;
?>

<div class="container mt-5">
    <h2 class="mb-4">GIỎ HÀNG</h2>

    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['cart'] as $id => $qty): 
                    // Sử dụng $productModel được truyền từ Controller
                    $product = $productModel->getById($id);
                    $subtotal = $product['price'] * $qty;
                    $total += $subtotal;
                ?>
                <tr>
                    <td>
                        <!-- Đường dẫn ảnh chuẩn từ thư mục gốc -->
                        <img src="public/images/<?php echo $product['image']; ?>" width="80">
                    </td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</td>
                    <td><?php echo $qty; ?></td>
                    <td class="text-danger fw-bold"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                    <td>
                        <a href="index.php?controller=cart&action=remove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm">X</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="text-end text-danger">
            Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> đ
        </h3>

        <div class="text-end mt-3">
            <a href="index.php" class="btn btn-secondary">Tiếp tục mua</a>
            <a href="checkout.php" class="btn btn-success">Thanh toán</a>
        </div>

    <?php else: ?>
        <div class="alert alert-info">Giỏ hàng đang trống!</div>
    <?php endif; ?>
</div>