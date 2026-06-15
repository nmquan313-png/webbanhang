<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <h2>Thêm sản phẩm mới</h2>
    
    <form id="addProductForm" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Danh mục</label>

        <select id="category_id" class="form-select" required>

            <option value="">Chọn danh mục</option>

            <?php
            $categories->execute();
            while($cat = $categories->fetch(PDO::FETCH_ASSOC)):
            ?>
                <option value="<?= $cat['id'] ?>">
                    <?= $cat['name'] ?>
                </option>
            <?php endwhile; ?>

        </select>

    </div>

    <div class="mb-3">
        <label class="form-label">Tên sản phẩm</label>
        <input type="text" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mô tả</label>
        <textarea id="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Giá</label>
        <input type="number" id="price" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Số lượng</label>
        <input type="number" id="quantity" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Hình ảnh</label>
        <input type="file" id="image" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Lưu
    </button>

    <a href="index.php?controller=product&action=list"
       class="btn btn-secondary">
        Hủy
    </a>

</form>
</div>
<script>

document
.getElementById("addProductForm")
.addEventListener("submit", function(e){

    e.preventDefault();

    let formData = new FormData();

    formData.append(
        "category_id",
        document.getElementById("category_id").value
    );

    formData.append(
        "name",
        document.getElementById("name").value
    );

    formData.append(
        "description",
        document.getElementById("description").value
    );

    formData.append(
        "price",
        document.getElementById("price").value
    );

    formData.append(
        "quantity",
        document.getElementById("quantity").value
    );

    formData.append(
        "image",
        document.getElementById("image").files[0]
    );

    fetch(
        "http://localhost:8080/api/add_product.php",
        {
            method: "POST",
            body: formData
        }
    )
    .then(response => response.json())
    .then(data => {

        if(data.success){

            alert("Thêm sản phẩm thành công");

            window.location.href =
            "index.php?controller=product&action=list";

        }else{

            alert("Thêm sản phẩm thất bại");

        }

    });

});

</script>

<?php include __DIR__ . '/../shares/footer.php'; ?>