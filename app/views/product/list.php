<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">

    <h2 class="mb-4">Danh sách sản phẩm</h2>

    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role']=='admin'): ?>
        <a href="index.php?controller=product&action=add"
           class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    <?php endif; ?>

    <div class="row" id="product-list">

    </div>

</div>

<script>

fetch("http://localhost:8080/api/products.php")
.then(response => response.json())
.then(products => {

    let html = "";

    products.forEach(product => {

        html += `
        <div class="col-md-3 mb-4">

            <div class="card product-card h-100">

                <img
                    src="public/images/${product.image}"
                    class="card-img-top product-img"
                    alt="${product.name}"
                >

                <div class="card-body">

                    <h5 class="card-title">
                        ${product.name}
                    </h5>

                    <p class="text-muted">
                        ${product.category_name ?? ''}
                    </p>

                    <p class="card-text text-danger fw-bold">
                        ${Number(product.price).toLocaleString()} ₫
                    </p>

                    <p class="card-text">
                        <small class="text-muted">
                            SL: ${product.quantity}
                        </small>
                    </p>

                </div>

                <div class="card-footer bg-white border-top-0">

                    <a
                        href="index.php?controller=product&action=detail&id=${product.id}"
                        class="btn btn-info btn-sm"
                    >
                        <i class="fas fa-eye"></i>
                    </a>

                </div>

            </div>

        </div>
        `;
    });

    document.getElementById("product-list").innerHTML = html;

})
.catch(error => {
    console.log(error);
});

</script>

<?php include __DIR__ . '/../shares/footer.php'; ?>