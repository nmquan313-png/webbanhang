<?php
include 'views/shares/header.php';

$success = isset($_GET['success']) ? $_GET['success'] : 0;
$order_id = isset($_GET['id']) ? $_GET['id'] : 0;
?>

<div class="container mt-5">
    <?php if ($success): ?>
    <div class="alert alert-success text-center">
        <h2><i class="fas fa-check-circle"></i> Đặt hàng thành công!</h2>
        <p class="lead">Mã đơn hàng của bạn: <strong>#<?= $order_id ?></strong></p>
        <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        <hr>
        <a href="index.php" class="btn btn-primary">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
    </div>
    <?php else: ?>
    <div class="alert alert-warning text-center">
        <h4>Không có đơn hàng nào</h4>
        <a href="index.php" class="btn btn-primary">Về trang chủ</a>
    </div>
    <?php endif; ?>
</div>

<?php include 'views/shares/footer.php'; ?>