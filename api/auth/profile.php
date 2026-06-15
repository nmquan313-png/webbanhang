<?php

require_once '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

$headers = getallheaders();

$token = str_replace(
    "Bearer ",
    "",
    $headers['Authorization']
);

$key = "WEBBANHANG_SECRET";

$data = JWT::decode(
    $token,
    new Key($key,'HS256')
);

echo json_encode([
    "id"=>$data->id,
    "email"=>$data->email,
    "role"=>$data->role
]);