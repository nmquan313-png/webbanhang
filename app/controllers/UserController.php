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

        echo "Đổi mật khẩu thành công";
        exit;
    }

    include "app/views/user/reset_password.php";
    }
}