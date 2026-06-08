<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-4">

    <h2>Quản lý người dùng</h2>

    <table class="table table-bordered">

        <thead>
            <tr>
                <th>ID</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>

        <tbody>

        <?php while($row = $users->fetch(PDO::FETCH_ASSOC)): ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td><?= $row['fullname']; ?></td>

                <td><?= $row['email']; ?></td>

                <td><?= $row['role']; ?></td>

                <td>
                    <?= ($row['status'] == 1) ? 'Hoạt động' : 'Đã khóa'; ?>
                </td>

                <td>

                    <?php
                    if($row['id'] == $_SESSION['user']['id'])
                    {
                        echo '<span class="badge bg-secondary">Tài khoản hiện tại</span>';
                    }
                    elseif($row['role'] == 'admin')
                    {
                        echo '<span class="badge bg-warning text-dark">Admin</span>';
                    }
                    elseif($row['status'] == 1)
                    {
                    ?>
                        <a href="index.php?controller=user&action=lock&id=<?= $row['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Khóa tài khoản này?')">
                            Khóa
                        </a>
                    <?php
                    }
                    else
                    {
                    ?>
                        <a href="index.php?controller=user&action=unlock&id=<?= $row['id']; ?>"
                        class="btn btn-success btn-sm">
                            Mở khóa
                        </a>
                    <?php
                    }
                    ?>

                    </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include APP_PATH.'/views/shares/footer.php'; ?>