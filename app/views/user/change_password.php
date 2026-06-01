public function changePassword()
{
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $userId = $_SESSION['user']['id'];

        $old = $_POST['old_password'];
        $new = $_POST['new_password'];

        $user = $this->model->getById($userId);

        if(password_verify($old,$user['password']))
        {
            $hash = password_hash($new,PASSWORD_DEFAULT);

            $this->model->updatePassword(
                $userId,
                $hash
            );

            echo "Đổi mật khẩu thành công";
        }
    }

    include "app/views/user/change_password.php";
}