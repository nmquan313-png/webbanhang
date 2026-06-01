
<?php include __DIR__ . '/../shares/header.php'; ?>

<style>
body{
    background: linear-gradient(135deg,#11998e,#38ef7d);
}

.register-box{
    max-width:500px;
    margin:40px auto;
}

.card{
    border:none;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.card-header{
    background:#198754;
    color:white;
    text-align:center;
    font-size:24px;
    font-weight:bold;
    border-radius:20px 20px 0 0 !important;
}

.btn-register{
    width:100%;
    border-radius:10px;
}
</style>

<div class="register-box">

    <div class="card">

        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            ĐĂNG KÝ TÀI KHOẢN
        </div>

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">
                    <label>Họ và tên</label>
                    <input
                        type="text"
                        name="fullname"
                        class="form-control"
                        required
                    >
                </div>

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

                <button class="btn btn-success btn-register">
                    <i class="fas fa-user-check"></i>
                    Đăng ký
                </button>

            </form>

            <hr>

            <p class="text-center">
                Đã có tài khoản?
                <a href="index.php?controller=user&action=login">
                    Đăng nhập
                </a>
            </p>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../shares/footer.php'; ?>
```
