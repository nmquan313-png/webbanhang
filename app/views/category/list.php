<?php include __DIR__ . '/../shares/header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Quản lý danh mục</h2>
    <a href="index.php?controller=category&action=add" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Thêm danh mục
    </a>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $categories->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td>
                    <a href="index.php?controller=category&action=edit&id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="index.php?controller=category&action=delete&id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc muốn xóa?')">
                        <i class="fas fa-trash"></i> Xóa
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>