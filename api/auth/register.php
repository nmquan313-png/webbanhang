<?php

require_once '../../app/config/database.php';

header('Content-Type: application/json');

$db = (new Database())->getConnection();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    exit();
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$password = $_POST['password'];

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $db->prepare("
INSERT INTO users
(
fullname,
email,
password
)
VALUES(?,?,?)
");

$result = $stmt->execute([
    $fullname,
    $email,
    $hash
]);

echo json_encode([
    "success"=>$result
]);