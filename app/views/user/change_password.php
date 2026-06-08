<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-5">
    <h2>Đổi mật khẩu</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Mật khẩu cũ</label>
            <input type="password"
                   name="old_password"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password"
                   name="new_password"
                   class="form-control">
        </div>

        <button class="btn btn-primary">
            Đổi mật khẩu
        </button>

    </form>
</div>

<?php include APP_PATH.'/views/shares/footer.php'; ?>