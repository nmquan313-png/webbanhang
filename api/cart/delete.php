<?php

session_start();

header('Content-Type: application/json');

$id = $_GET['id'] ?? 0;

unset($_SESSION['cart'][$id]);

echo json_encode([
    "success"=>true
]);