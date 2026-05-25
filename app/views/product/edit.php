<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <h2>Sửa sản phẩm</h2>
    
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <?php 
                $categories->execute();
                while($cat = $categories->fetch(PDO::FETCH_ASSOC)): 
                ?>
                <option value="<?= $cat['id'] ?>" 
                        <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= $cat['name'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" 
                   value="<?= $product['name'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"><?= $product['description'] ?></textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" class="form-control" 
                   value="<?= $product['price'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" name="quantity" class="form-control" 
                   value="<?= $product['quantity'] ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Hình ảnh hiện tại</label><br>
            <img src="public/images/<?= $product['image'] ?>" width="100"><br>
            <label class="form-label mt-2">Đổi hình ảnh (để trống nếu không đổi)</label>
            <input type="file" name="image" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Cập nhật
        </button>
        <a href="index.php?controller=product&action=list" class="btn btn-secondary">
            <i class="fas fa-times"></i> Hủy
        </a>
    </form>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>