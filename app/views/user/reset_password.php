<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-5 mb-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-primary text-white text-center">

                    <h3>
                        <i class="fas fa-key"></i>
                        Đặt lại mật khẩu
                    </h3>

                </div>

                <div class="card-body p-4">

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Mật khẩu mới
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Nhập mật khẩu mới"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-success w-100"
                        >
                            <i class="fas fa-save"></i>
                            Đổi mật khẩu
                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    <a href="index.php?controller=user&action=login">
                        Quay lại đăng nhập
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include APP_PATH.'/views/shares/footer.php'; ?>