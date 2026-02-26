<?php

// Izinkan akses dari localhost:8000
header("Access-Control-Allow-Origin: http://localhost:8000");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Ambil path yang diminta
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

// Bersihkan path
$path = ltrim($path, '/');

// Cek apakah file JSON ada
$filePath = __DIR__ . '/api/' . $path;

if (file_exists($filePath) && is_file($filePath)) {
    header('Content-Type: application/json');
    readfile($filePath);
} elseif (file_exists($filePath . '.json')) {
    header('Content-Type: application/json');
    readfile($filePath . '.json');
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not Found']);
}
