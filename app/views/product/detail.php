<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">

    <div class="row">

        <div class="col-md-5">
            <img src="public/images/<?= $product['image'] ?>"
                 class="img-fluid">
        </div>

        <div class="col-md-7">

            <h2><?= $product['name'] ?></h2>

            <h5 class="text-muted">
                <?= $product['category_name'] ?>
            </h5>

            <h3 class="text-danger">
                <?= number_format($product['price']) ?> ₫
            </h3>

            <p>
                <?= $product['description'] ?>
            </p>

            <p>
                Số lượng:
                <?= $product['quantity'] ?>
            </p>

            <form method="POST"
                  action="cart.php">

                <input type="hidden"
                       name="product_id"
                       value="<?= $product['id'] ?>">

                <input type="hidden"
                       name="name"
                       value="<?= $product['name'] ?>">

                <input type="hidden"
                       name="price"
                       value="<?= $product['price'] ?>">

                <input type="hidden"
                       name="image"
                       value="<?= $product['image'] ?>">

                <input type="hidden"
                       name="quantity"
                       value="1">

                <button type="submit"
                        name="add_to_cart"
                        class="btn btn-success">
                    Thêm vào giỏ hàng
                </button>

            </form>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>