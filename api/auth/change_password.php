<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$stmt = $db->prepare("
SELECT *
FROM users
WHERE id=?
");

$stmt->execute([
    $data['id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(
!password_verify(
$data['old_password'],
$user['password']
))
{
    echo json_encode([
        "success"=>false,
        "message"=>"Mật khẩu cũ không đúng"
    ]);
    exit();
}

$newHash = password_hash(
    $data['new_password'],
    PASSWORD_DEFAULT
);

$stmt = $db->prepare("
UPDATE users
SET password=?
WHERE id=?
");

$result = $stmt->execute([
    $newHash,
    $data['id']
]);

echo json_encode([
    "success"=>$result
]);