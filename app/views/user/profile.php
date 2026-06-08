<?php include APP_PATH.'/views/shares/header.php'; ?>

<div class="container mt-4">

    <div class="card shadow p-4">

        <h2 class="text-center mb-4">
            Thông tin cá nhân
        </h2>

        <?php
        $avatar = !empty($_SESSION['user']['avatar'])
            ? $_SESSION['user']['avatar']
            : 'default.png';
        ?>

        <div class="text-center mb-4">
            <img
                src="public/avatar/<?= $avatar; ?>"
                width="150"
                height="150"
                class="rounded-circle border"
                style="object-fit:cover;"
            >
        </div>

        <hr>

        <p>
            <strong>Họ tên:</strong>
            <?= $_SESSION['user']['fullname']; ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?= $_SESSION['user']['email']; ?>
        </p>

        <p>
            <strong>Vai trò:</strong>
            <?= $_SESSION['user']['role']; ?>
        </p>

        <hr>

        <h4 class="mb-3">
            Đổi mật khẩu
        </h4>

        <form
            method="POST"
            action="index.php?controller=user&action=changePassword"
        >

            <div class="mb-3">
                <label class="form-label">
                    Mật khẩu hiện tại
                </label>

                <input
                    type="password"
                    name="old_password"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Mật khẩu mới
                </label>

                <input
                    type="password"
                    name="new_password"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Nhập lại mật khẩu mới
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    class="form-control"
                    required
                >
            </div>

            <button
                type="submit"
                class="btn btn-warning"
            >
                Đổi mật khẩu
            </button>

        </form>

        <hr>

        <h4 class="mb-3">
            Đổi ảnh đại diện
        </h4>

        <form
            method="POST"
            action="index.php?controller=user&action=uploadAvatar"
            enctype="multipart/form-data"
        >

            <input
                type="file"
                name="avatar"
                class="form-control"
                required
            >

            <button
                type="submit"
                class="btn btn-primary mt-3"
            >
                Cập nhật ảnh
            </button>

        </form>

    </div>

</div>

<?php include APP_PATH.'/views/shares/footer.php'; ?>