<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Danh sách sản phẩm</h2>
    <a href="index.php?controller=product&action=add" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
    
    <div class="row">
        <?php while($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="col-md-3 mb-4">
            <div class="card product-card h-100">
                <img src="public/images/<?= $row['image'] ?>" 
                     class="card-img-top product-img" alt="<?= $row['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row['name'] ?></h5>
                    <p class="text-muted"><?= $row['category_name'] ?></p>
                    <p class="card-text text-danger fw-bold">
                        <?= number_format($row['price'], 0, ',', '.') ?> ₫
                    </p>
                    <p class="card-text">
                        <small class="text-muted">SL: <?= $row['quantity'] ?></small>
                    </p>
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="index.php?controller=product&action=edit&id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="index.php?controller=product&action=delete&id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc muốn xóa?')">
                        <i class="fas fa-trash"></i>
                    </a>
                    <form method="POST" action="cart.php" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="name" value="<?= $row['name'] ?>">
                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                        <input type="hidden" name="image" value="<?= $row['image'] ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" name="add_to_cart" class="btn btn-success btn-sm">
                            <i class="fas fa-cart-plus"></i> Thêm
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>