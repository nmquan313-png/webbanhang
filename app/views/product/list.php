
<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">

    <h2 class="mb-4">Danh sách sản phẩm</h2>

    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
        <a href="index.php?controller=product&action=add" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    <?php endif; ?>

    <div class="row">

        <?php while($row = $products->fetch(PDO::FETCH_ASSOC)): ?>

        <div class="col-md-3 mb-4">

            <div class="card product-card h-100">

                <img
                    src="public/images/<?= $row['image'] ?>"
                    class="card-img-top product-img"
                    alt="<?= $row['name'] ?>"
                >

                <div class="card-body">

                    <h5 class="card-title">
                        <?= $row['name'] ?>
                    </h5>

                    <p class="text-muted">
                        <?= $row['category_name'] ?>
                    </p>

                    <p class="card-text text-danger fw-bold">
                        <?= number_format($row['price'],0,',','.') ?> ₫
                    </p>

                    <p class="card-text">
                        <small class="text-muted">
                            SL: <?= $row['quantity'] ?>
                        </small>
                    </p>

                </div>

                <div class="card-footer bg-white border-top-0">

                    <!-- Chi tiết -->
                    <a
                        href="index.php?controller=product&action=detail&id=<?= $row['id'] ?>"
                        class="btn btn-info btn-sm"
                    >
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Admin -->
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role']=='admin'): ?>

                        <a
                            href="index.php?controller=product&action=edit&id=<?= $row['id'] ?>"
                            class="btn btn-warning btn-sm"
                        >
                            <i class="fas fa-edit"></i>
                        </a>

                        <a
                            href="index.php?controller=product&action=delete&id=<?= $row['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Bạn có chắc muốn xóa?')"
                        >
                            <i class="fas fa-trash"></i>
                        </a>

                    <?php endif; ?>

                   <!-- Giỏ hàng -->

<?php if(isset($_SESSION['user'])): ?>

<form
    method="POST"
    action="index.php?controller=product&action=addToCart"
    style="display:inline;"
>

    <input
        type="hidden"
        name="product_id"
        value="<?= $row['id'] ?>"
    >

    <button
        type="submit"
        class="btn btn-success btn-sm"
    >
        <i class="fas fa-cart-plus"></i>
        Thêm
    </button>

</form>

<?php else: ?>

<a
    href="index.php?controller=user&action=login"
    class="btn btn-secondary btn-sm"
>
    <i class="fas fa-lock"></i>
    Đăng nhập để mua
</a>

<?php endif; ?>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>