<?php
header('Content-Type: application/json');

$schemaPath = __DIR__ . '/../data-schema.json';

if (!file_exists($schemaPath)) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'data-schema.json was not found.'
    ]);
    exit;
}

$json = file_get_contents($schemaPath);
$data = json_decode($json, true);

if ($data === null) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'data-schema.json could not be parsed.'
    ]);
    exit;
}

echo json_encode($data);
