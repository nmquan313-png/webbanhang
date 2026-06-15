<?php

require_once '../../vendor/autoload.php';
require_once '../../app/config/database.php';

use Firebase\JWT\JWT;

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(empty($email) || empty($password))
{
    echo json_encode([
        "success" => false,
        "message" => "Thiếu email hoặc password"
    ]);
    exit();
}

$stmt = $db->prepare("
    SELECT *
    FROM users
    WHERE email = ?
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user)
{
    echo json_encode([
        "success" => false,
        "message" => "Email không tồn tại"
    ]);
    exit();
}

if(isset($user['status']) && $user['status'] == 0)
{
    echo json_encode([
        "success" => false,
        "message" => "Tài khoản đã bị khóa"
    ]);
    exit();
}

if(!password_verify($password, $user['password']))
{
    echo json_encode([
        "success" => false,
        "message" => "Sai mật khẩu"
    ]);
    exit();
}

$key = "WEBBANHANG_SECRET";

$payload = [
    "id"    => $user['id'],
    "email" => $user['email'],
    "role"  => $user['role'],
    "exp"   => time() + 3600
];

$token = JWT::encode(
    $payload,
    $key,
    'HS256'
);

echo json_encode([
    "success" => true,
    "message" => "Đăng nhập thành công",
    "token" => $token,
    "user" => [
        "id" => $user['id'],
        "fullname" => $user['fullname'],
        "email" => $user['email'],
        "role" => $user['role']
    ]
]);