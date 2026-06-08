<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-5">

    <h2>Quên mật khẩu</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control">
        </div>

        <button class="btn btn-warning">
            Gửi yêu cầu
        </button>

    </form>

</div>

<?php include APP_PATH.'/views/shares/footer.php'; ?>