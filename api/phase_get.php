<?php
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';

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

function decode_json_column($value, $fallback = [])
{
    if ($value === null || $value === '') {
        return $fallback;
    }

    $decoded = json_decode($value, true);

    return is_array($decoded) ? $decoded : $fallback;
}

function load_phase_from_mysql($phaseId)
{
    $pdo = get_database_connection();

    if (!$pdo) {
        return null;
    }

    try {
        $statement = $pdo->prepare(
            'SELECT
                mp.phase_id,
                mp.phase_title,
                mp.alert_level,
                mp.color_status,
                mp.highlighted_body_zone,
                mp.highlighted_body_zones,
                mp.telemetry_chart,
                b.heart_rate,
                b.blood_pressure,
                b.oxygen_level,
                b.radiation_level,
                b.sleep_hours,
                b.bone_density,
                b.exercise_status,
                b.mental_status,
                ap.predicted_problem,
                ap.reasoning,
                ap.recommended_action,
                cl.response_chatbot
            FROM mission_phases mp
            LEFT JOIN biometrics b
                ON b.phase_id = mp.phase_id
            LEFT JOIN ai_predictions ap
                ON ap.phase_id = mp.phase_id
            LEFT JOIN chatbot_logs cl
                ON cl.phase_id = mp.phase_id
            WHERE mp.phase_id = :phase_id
            ORDER BY
                b.recorded_at DESC,
                ap.created_at DESC,
                cl.created_at DESC
            LIMIT 1'
        );

        $statement->execute(['phase_id' => $phaseId]);
        $row = $statement->fetch();

        if (!$row) {
            return null;
        }

        $requiredFields = [
            'heart_rate',
            'blood_pressure',
            'oxygen_level',
            'radiation_level',
            'sleep_hours',
            'bone_density',
            'exercise_status',
            'mental_status',
            'predicted_problem',
            'reasoning',
            'recommended_action',
            'response_chatbot'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($row[$field]) || $row[$field] === '') {
                return null;
            }
        }

        $highlightedZones = decode_json_column($row['highlighted_body_zones'], []);

        if (empty($highlightedZones) && !empty($row['highlighted_body_zone'])) {
            $highlightedZones = [$row['highlighted_body_zone']];
        }

        return [
            'phase_id' => $row['phase_id'],
            'phase_title' => $row['phase_title'],
            'alert_level' => $row['alert_level'],
            'heart_rate' => $row['heart_rate'],
            'blood_pressure' => $row['blood_pressure'],
            'oxygen_level' => $row['oxygen_level'],
            'radiation_level' => $row['radiation_level'],
            'sleep_hours' => $row['sleep_hours'],
            'bone_density' => $row['bone_density'],
            'exercise_status' => $row['exercise_status'],
            'mental_status' => $row['mental_status'],
            'ai_prediction' => $row['predicted_problem'],
            'ai_reasoning' => $row['reasoning'],
            'medical_recommendation' => $row['recommended_action'],
            'chatbot_message' => $row['response_chatbot'],
            'highlighted_body_zone' => $row['highlighted_body_zone'],
            'highlighted_body_zones' => $highlightedZones,
            'color_status' => $row['color_status'],
            'telemetry_chart' => decode_json_column($row['telemetry_chart'], []),
            'data_source' => 'mysql'
        ];
    } catch (PDOException $error) {
        error_log('AstroHealth phase MySQL lookup failed: ' . $error->getMessage());
        return null;
    }
}

$phaseId = trim($_GET['phase_id'] ?? '');

if ($phaseId === '') {
    send_json([
        'status' => 'error',
        'message' => 'Missing required query parameter: phase_id.'
    ], 400);
}

$mysqlPhase = load_phase_from_mysql($phaseId);

if ($mysqlPhase !== null) {
    send_json($mysqlPhase);
}

$data = load_schema();
$phase = $data['mission_phases'][$phaseId] ?? null;

if ($phase === null) {
    send_json([
        'status' => 'error',
        'message' => 'Invalid phase_id.',
        'phase_id' => $phaseId
    ], 404);
}

$phase['data_source'] = 'json_fallback';

send_json($phase);
