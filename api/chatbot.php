<?php
header('Content-Type: application/json');

function send_json($payload, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode($payload);
    exit;
}

function load_schema()
{
    $schemaPath = __DIR__ . '/../data-schema.json';

    if (!file_exists($schemaPath)) {
        send_json([
            'status' => 'error',
            'message' => 'data-schema.json was not found.'
        ], 500);
    }

    $data = json_decode(file_get_contents($schemaPath), true);

    if ($data === null) {
        send_json([
            'status' => 'error',
            'message' => 'data-schema.json could not be parsed.'
        ], 500);
    }

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Only POST requests are supported.'
    ], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Request body must be valid JSON.'
    ], 400);
}

$phaseId = $input['phase_id'] ?? '';
$userMessage = $input['user_message'] ?? '';

if ($phaseId === '') {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Missing required field: phase_id.'
    ], 400);
}

if (!is_string($phaseId) || !is_string($userMessage)) {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'phase_id and user_message must be strings.'
    ], 400);
}

$phaseId = trim($phaseId);
$userMessage = trim($userMessage);

if ($phaseId === '') {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Missing required field: phase_id.'
    ], 400);
}

$data = load_schema();
$phase = $data['mission_phases'][$phaseId] ?? null;

if ($phase === null) {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Invalid phase_id.',
        'phase_id' => $phaseId
    ], 404);
}

// Future AI integration point:
// Replace this rule-based classifier with Taqwa's Python/AI chatbot model.
// Keep the response contract stable so the frontend can keep consuming the same JSON.
function build_rule_based_chatbot_response($phase, $userMessage)
{
    $messageLower = strtolower($userMessage);
    $mentalKeywords = ['sad', 'lonely', 'afraid', 'tired', 'depressed', 'anxious'];
    $isMentalSupport = false;

    foreach ($mentalKeywords as $keyword) {
        if (strpos($messageLower, $keyword) !== false) {
            $isMentalSupport = true;
            break;
        }
    }

    if ($isMentalSupport) {
        $detectedEmotion = 'mental_health_stress';
        $confidenceScore = 0.92;
        $response = 'Adam, I hear you. You are not alone. Let us slow the next minute down: breathe in for four seconds, breathe out for six, and send one short status note to mission control.';
        $environmentControl = [
            'change_lighting_color' => '#FF8C00',
            'play_background_sound' => 'earth_rain.mp3'
        ];
    } else {
        $detectedEmotion = 'mission_status_check';
        $confidenceScore = 0.74;
        $response = $phase['chatbot_message'];
        $environmentControl = [
            'change_lighting_color' => '#2F80ED',
            'play_background_sound' => 'mission_ambient.mp3'
        ];
    }

    return [
        'status' => 'success',
        'source' => 'rule_based_placeholder',
        'detected_emotion' => $detectedEmotion,
        'confidence_score' => $confidenceScore,
        'response_chatbot' => $response,
        'environment_control_trigger' => $environmentControl
    ];
}

send_json(build_rule_based_chatbot_response($phase, $userMessage));
