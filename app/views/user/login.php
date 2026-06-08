
<?php include __DIR__ . '/../shares/header.php'; ?>

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
}

.login-box{
    max-width:450px;
    margin:50px auto;
}

.card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.card-header{
    background:#0d6efd;
    color:white;
    text-align:center;
    font-size:24px;
    font-weight:bold;
    border-radius:20px 20px 0 0 !important;
}

.btn-login{
    width:100%;
    border-radius:10px;
}
</style>

<div class="login-box">

    <div class="card">

        <div class="card-header">
            <i class="fas fa-user-circle"></i>
            ĐĂNG NHẬP
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        required
                    >
                </div>

                <button class="btn btn-primary btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Đăng nhập
                </button>

            </form>

            <hr>

            <p class="text-center">
                Chưa có tài khoản?
                <a href="index.php?controller=user&action=register">
                    Đăng ký ngay
                </a>
            </p>

            <p class="text-center">
                <a href="index.php?controller=user&action=forgotPassword">
                    Quên mật khẩu?
                </a>
            </p>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>
```
