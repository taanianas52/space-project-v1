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

function get_highlighted_body_zones($phase)
{
    if (!empty($phase['highlighted_body_zones']) && is_array($phase['highlighted_body_zones'])) {
        return $phase['highlighted_body_zones'];
    }

    if (!empty($phase['highlighted_body_zone']) && $phase['highlighted_body_zone'] !== 'none') {
        return [$phase['highlighted_body_zone']];
    }

    return [];
}

// Future AI integration point:
// Replace this function with a call to Taqwa's Python/AI risk model.
// Keep the returned keys stable so the frontend does not need to change.
function build_rule_based_risk_response($phase)
{
    $highlightedZones = get_highlighted_body_zones($phase);

    return [
        'status' => 'success',
        'source' => 'rule_based_placeholder',
        'phase_id' => $phase['phase_id'],
        'risk_level' => $phase['alert_level'],
        'predicted_problem' => $phase['ai_prediction'],
        'reasoning' => $phase['ai_reasoning'],
        'recommended_action' => $phase['medical_recommendation'],
        'highlighted_body_zones' => $highlightedZones,

        // Compatibility aliases for any current frontend or test code using old names.
        'alert_level' => $phase['alert_level'],
        'ai_engine' => 'AI Risk Engine Simulation',
        'ai_prediction' => $phase['ai_prediction'],
        'ai_reasoning' => $phase['ai_reasoning'],
        'highlighted_body_zone' => $phase['highlighted_body_zone'] ?? ($highlightedZones[0] ?? 'none'),
        'medical_recommendation' => $phase['medical_recommendation']
    ];
}

$phaseId = trim($_GET['phase_id'] ?? '');

if ($phaseId === '') {
    send_json([
        'status' => 'error',
        'source' => 'rule_based_placeholder',
        'message' => 'Missing required query parameter: phase_id.'
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

send_json(build_rule_based_risk_response($phase));
