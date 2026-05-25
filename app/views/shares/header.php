<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điện Tử Store - Bán hàng đồ điện tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand { font-weight: bold; font-size: 24px; }
        .product-card { transition: transform 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .product-img { height: 200px; object-fit: contain; padding: 20px; }
        .cart-icon { position: relative; }
        .cart-badge { 
            position: absolute; 
            top: -5px; 
            right: -5px; 
            background: red; 
            color: white; 
            border-radius: 50%; 
            padding: 2px 6px; 
            font-size: 12px; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-mobile-alt"></i> ĐIỆN TỬ STORE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=product&action=list">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=category&action=list">Danh mục</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link cart-icon" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Giỏ hàng
                            <?php
                            session_start();
                            $count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                            if ($count > 0) {
                                echo '<span class="cart-badge">' . $count . '</span>';
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>