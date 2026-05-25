<?php
session_start();
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($order_id == 0) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success text-center py-5">
        <i class="fas fa-check-circle fa-5x mb-3 text-success"></i>
        <h2 class="display-4">Đặt hàng thành công!</h2>
        <p class="lead">Mã đơn hàng của bạn: <strong>#<?php echo $order_id; ?></strong></p>
        <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        <hr class="my-4">
        <a href="index.php" class="btn btn-primary btn-lg">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
    </div>
</div>
</body>
</html>