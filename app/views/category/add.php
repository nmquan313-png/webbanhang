<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <h2><?= isset($category) ? 'Sửa danh mục' : 'Thêm danh mục' ?></h2>
    
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="name" class="form-control" 
                   value="<?= isset($category) ? $category['name'] : '' ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Lưu
        </button>
        <a href="index.php?controller=category&action=list" class="btn btn-secondary">
            <i class="fas fa-times"></i> Hủy
        </a>
    </form>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>