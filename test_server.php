<?php
$data = json_decode(file_get_contents('php://input'), true);

$key = 'test';
$password = 123;

if ($data[$key] == $password || (array_key_exists($key, $_POST) && $_POST[$key] == $password)) {
    return http_response_code(200);
} else {
    return http_response_code(403);
}
