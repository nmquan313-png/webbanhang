<?php

require_once "app/config/database.php";

class UserModel {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function register($fullname, $email, $password) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(fullname,email,password)
                VALUES(?,?,?)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            $fullname,
            $email,
            $hash
        ]);
    }

    public function login($email) {

        $sql = "SELECT * FROM users WHERE email=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveResetToken($email,$token){
    $sql = "UPDATE users
            SET reset_token=?
            WHERE email=?";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $token,
        $email
    ]);
    }
    
    public function updatePasswordByToken(
    $token,
    $password
){
    $sql = "UPDATE users
            SET password=?,
                reset_token=NULL
            WHERE reset_token=?";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $password,
        $token
    ]);
    }

    public function updateAvatar($id,$avatar){
    $sql =
    "UPDATE users
    SET avatar=?
    WHERE id=?";

    $stmt =
    $this->conn->prepare($sql);

    return $stmt->execute([
        $avatar,
        $id
    ]);
    }

    public function lockUser($id)
{
    $sql =
    "UPDATE users
    SET status=0
    WHERE id=?";

    $stmt =
    $this->conn->prepare($sql);

    return $stmt->execute([$id]);
}

    public function updatePassword($id,$password){
    $sql = "UPDATE users
            SET password=?
            WHERE id=?";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        $password,
        $id
    ]);
    }

    public function getAllUsers(){
    $sql = "SELECT * FROM users";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt;
    }
}