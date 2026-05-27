<?php
header('Content-Type: application/json');

function load_schema()
{
    $schemaPath = __DIR__ . '/../data-schema.json';

    if (!file_exists($schemaPath)) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'data-schema.json was not found.'
        ]);
        exit;
    }

    $data = json_decode(file_get_contents($schemaPath), true);

    if ($data === null) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'data-schema.json could not be parsed.'
        ]);
        exit;
    }

    return $data;
}

$phaseId = $_GET['phase_id'] ?? '';

if ($phaseId === '') {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required query parameter: phase_id.'
    ]);
    exit;
}

$data = load_schema();
$phase = $data['mission_phases'][$phaseId] ?? null;

if ($phase === null) {
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid phase_id.',
        'phase_id' => $phaseId
    ]);
    exit;
}

echo json_encode($phase);
