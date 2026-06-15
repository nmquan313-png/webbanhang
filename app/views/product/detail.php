<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-5">

    <div id="product-detail">

        <div class="text-center">
            <div class="spinner-border"></div>
        </div>

    </div>

</div>
<script>

const params = new URLSearchParams(window.location.search);
const id = params.get('id');

fetch('http://localhost:8080/api/product_detail.php?id=' + id)
.then(response => response.json())
.then(result => {

    if(!result.success){
        document.getElementById('product-detail').innerHTML =
        '<div class="alert alert-danger">Không tìm thấy sản phẩm</div>';
        return;
    }

    let product = result.data;

    document.getElementById('product-detail').innerHTML = `
    <div class="row">

        <div class="col-md-5">
            <img src="public/images/${product.image}"
                 class="img-fluid">
        </div>

        <div class="col-md-7">

            <h2>${product.name}</h2>

            <h5 class="text-muted">
                ${product.category_name ?? ''}
            </h5>

            <h3 class="text-danger">
                ${Number(product.price).toLocaleString()} ₫
            </h3>

            <p>${product.description}</p>

            <p>Số lượng: ${product.quantity}</p>

            <a href="index.php?controller=product&action=list"
               class="btn btn-secondary">
               Quay lại
            </a>

        </div>

    </div>
    `;
});

</script>

<?php include APP_PATH.'/views/shares/footer.php'; ?>