<?php

header('Content-Type: application/json');

echo json_encode([
    "success"=>true,
    "message"=>"Link đặt lại mật khẩu đã được gửi tới email"
]);