<?php

require_once "app/models/UserModel.php";

class UserController {

    public function register() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $model = new UserModel();

            $result = $model->register(
                $_POST['fullname'],
                $_POST['email'],
                $_POST['password']
            );

            if($result){
                echo "<script>
                        alert('Đăng ký thành công');
                        window.location='index.php?controller=user&action=login';
                      </script>";
                exit;
            } else {
                echo "Đăng ký thất bại";
            }
        }

        include "app/views/user/register.php";
    }

    public function login() {

        if($_SERVER['REQUEST_METHOD'] == "POST") {

            $model = new UserModel();

            $user = $model->login($_POST['email']);

            if(
                $user &&
                password_verify(
                    $_POST['password'],
                    $user['password']
                )
            ) {

                $_SESSION['user'] = $user;

                header("Location: index.php");
                exit;
            }

            echo "Sai tài khoản hoặc mật khẩu";
        }

        include "app/views/user/login.php";
    }

    public function logout() {

        session_destroy();

        header("Location: index.php");
        exit;
    }

    public function forgotPassword(){
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $email = $_POST['email'];

        $token = md5(time());

        $model = new UserModel();

        $model->saveResetToken($email,$token);

        echo "Link đặt lại mật khẩu:<br>";
        echo "<a href='index.php?controller=user&action=resetPassword&token=$token'>
                Đặt lại mật khẩu
              </a>";
    }

    include "app/views/user/forgot_password.php";
    }

    public function resetPassword(){
    $token = $_GET['token'];

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $password = password_hash(
            $_POST['password'],
            PASSWORD_DEFAULT
        );

        $model = new UserModel();

        $model->updatePasswordByToken(
            $token,
            $password
        );

        $_SESSION['success'] = "Đổi mật khẩu thành công!";
        header("Location: index.php?controller=user&action=login");
        exit;;
    }

    include "app/views/user/reset_password.php";
    }

    public function profile(){
    include APP_PATH."/views/user/profile.php";
    }

    public function uploadAvatar(){
    $file = time().'_'.$_FILES['avatar']['name'];

    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        'public/avatar/'.$file
    );

    $model = new UserModel();

    $model->updateAvatar(
        $_SESSION['user']['id'],
        $file
    );

    $_SESSION['user']['avatar'] = $file;

    header("Location: index.php?controller=user&action=profile");
    exit;
    }

    public function changePassword(){
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $model = new UserModel();

        $user = $model->login($_SESSION['user']['email']);

        if(
            !password_verify(
                $_POST['old_password'],
                $user['password']
            )
        ){
            echo "<script>
                    alert('Mật khẩu cũ không đúng');
                    history.back();
                  </script>";
            exit;
        }

        if(
            $_POST['new_password']
            !=
            $_POST['confirm_password']
        ){
            echo "<script>
                    alert('Mật khẩu xác nhận không khớp');
                    history.back();
                  </script>";
            exit;
        }

        $hash = password_hash(
            $_POST['new_password'],
            PASSWORD_DEFAULT
        );

        $model->updatePassword(
            $_SESSION['user']['id'],
            $hash
        );

        echo "<script>
                alert('Đổi mật khẩu thành công');
                window.location='index.php?controller=user&action=profile';
              </script>";
        exit;
    }
    }

    public function list()
    {
        $model = new UserModel();
    
        $users = $model->getAllUsers();
    
        include APP_PATH.'/views/user/list.php';
    }

    public function lock(){
    if($_GET['id'] == $_SESSION['user']['id'])
    {
        die("Không thể khóa chính tài khoản đang đăng nhập");
    }

    $this->userModel->lockUser($_GET['id']);

    header("Location:index.php?controller=user&action=list");
    }

    public function unlock(){
    $this->userModel->unlockUser($_GET['id']);
    header("Location:index.php?controller=user&action=list");
    }
}