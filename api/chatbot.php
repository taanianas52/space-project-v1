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
function text_has_any_keyword($messageLower, $keywords)
{
    foreach ($keywords as $keyword) {
        if (strpos($messageLower, $keyword) !== false) {
            return true;
        }
    }

    return false;
}

function detect_rule_based_emotion($userMessage, $phase)
{
    $messageLower = strtolower($userMessage);
    $mentalStatus = strtolower($phase['mental_status'] ?? '');

    $emotionRules = [
        'isolated' => ['lonely', 'alone', 'isolated', 'homesick', 'disconnected'],
        'exhausted' => ['tired', 'exhausted', 'fatigue', 'fatigued', 'sleepy', 'drained'],
        'anxious' => ['anxious', 'panic', 'panicked', 'worried', 'afraid', 'scared', 'nervous'],
        'confused' => ['confused', 'unclear', 'dizzy', 'disoriented', 'lost', 'not sure'],
        'stressed' => ['stress', 'stressed', 'overwhelmed', 'pressure', 'tense'],
        'calm' => ['calm', 'fine', 'stable', 'ready', 'focused', 'okay', 'ok']
    ];

    foreach ($emotionRules as $emotion => $keywords) {
        if (text_has_any_keyword($messageLower, $keywords) || text_has_any_keyword($mentalStatus, $keywords)) {
            return $emotion;
        }
    }

    if (($phase['phase_id'] ?? '') === 'mental_health_isolation') {
        return 'isolated';
    }

    if (($phase['phase_id'] ?? '') === 'launch_stress') {
        return 'stressed';
    }

    if (($phase['phase_id'] ?? '') === 'solar_radiation_storm') {
        return 'anxious';
    }

    return 'calm';
}

function get_emotion_confidence_score($emotion)
{
    $scores = [
        'calm' => 0.78,
        'stressed' => 0.86,
        'anxious' => 0.88,
        'isolated' => 0.92,
        'exhausted' => 0.84,
        'confused' => 0.82
    ];

    return $scores[$emotion] ?? 0.74;
}

function get_environment_control($emotion, $phaseId)
{
    if ($phaseId === 'solar_radiation_storm') {
        return [
            'change_lighting_color' => '#D84D57',
            'play_background_sound' => 'emergency_tone.mp3'
        ];
    }

    if ($emotion === 'isolated' || $phaseId === 'mental_health_isolation') {
        return [
            'change_lighting_color' => '#FF8C00',
            'play_background_sound' => 'earth_rain.mp3'
        ];
    }

    if ($emotion === 'exhausted') {
        return [
            'change_lighting_color' => '#6AA6D9',
            'play_background_sound' => 'sleep_cycle_soft.mp3'
        ];
    }

    return [
        'change_lighting_color' => '#2F80ED',
        'play_background_sound' => 'mission_ambient.mp3'
    ];
}

function pick_response_variation($responses, $phaseId, $emotion, $userMessage)
{
    $seed = crc32($phaseId . '|' . $emotion . '|' . strtolower($userMessage) . '|' . gmdate('Y-m-d H'));
    $index = $seed % count($responses);

    return $responses[$index];
}

function get_phase_guidance($phase, $emotion)
{
    $phaseId = $phase['phase_id'] ?? '';

    $phaseResponses = [
        'launch_stress' => [
            'Adam, launch stress is expected, but we will control the next minute. Keep your shoulders against the seat, breathe in for four, out for six, and report chest pressure, dizziness, or tunnel vision.',
            'I am tracking the cardiovascular load. Stay secured, keep your breathing slow, and let the crew medical loop know if the pressure feels sharp or unusual.',
            'Launch phase support is active. Focus on one breath cycle at a time while I monitor heart rate, blood pressure, and oxygen stability.'
        ],
        'solar_radiation_storm' => [
            'Radiation protocol is active. Move to the shielded area now, reduce nonessential movement, and confirm when you are secured.',
            'This is an emergency exposure window. Shelter first, then report nausea, headache, visual changes, or unusual fatigue to mission control.',
            'Adam, prioritize shielding. I will keep tracking radiation and stress markers while you limit exposure time.'
        ],
        'mental_health_isolation' => [
            'Adam, I hear you. You are not alone in this mission. Name one thing you can see, slow your breathing, and send a short emotional status check to mission control.',
            'Psychological support channel is open. Let us reduce the next task to one small step, then schedule a connection window with home or crew support.',
            'Isolation can distort the sense of time. Stay with me for the next minute: breathe slowly, unclench your jaw, and rate your stress from 1 to 10.'
        ],
        'exercise_neglect' => [
            'Your body needs countermeasure support. Start with a short resistance set focused on legs and pelvis, then log completion so bone-density risk can be tracked.',
            'Exercise recovery plan active. Keep the session short, controlled, and lower-body focused today. I will watch fatigue and motivation markers.',
            'Adam, missed exercise is fixable. Begin a brief loading routine and report any pain, dizziness, or unusual weakness.'
        ],
        'zero_gravity' => [
            'Microgravity adaptation is active. Move slowly, hydrate, and report balance changes, headache, or spinal discomfort.',
            'I am watching fluid shift and early skeletal unloading. Keep resistance exercise on schedule and protect your sleep cycle tonight.',
            'Zero-G can feel strange at first. Use slow head turns, steady breathing, and keep me updated on balance and nausea.'
        ]
    ];

    if (isset($phaseResponses[$phaseId])) {
        return $phaseResponses[$phaseId];
    }

    $emotionResponses = [
        'calm' => [
            $phase['chatbot_message'],
            'Adam, your status sounds controlled. Continue the checklist and keep reporting any new symptom early.',
            'Telemetry support is steady. Maintain hydration, breathing rhythm, and mission task pacing.'
        ],
        'stressed' => [
            'I detect stress markers. Pause for one controlled breath cycle, then continue only the next checklist item.',
            'Stress response acknowledged. Slow the pace, relax your shoulders, and keep mission control informed.',
            'Let us stabilize first: inhale for four seconds, exhale for six, then confirm your current symptom level.'
        ],
        'anxious' => [
            'Anxiety response detected. Focus on the next physical action only, and tell me if you feel chest pain, dizziness, or shortness of breath.',
            'I am with you. Keep your breathing measured and give mission control a short status update.',
            'Anxiety can spike quickly in flight. Anchor on the checklist, one step at a time.'
        ],
        'isolated' => [
            'Isolation signal detected. Open a private support channel, send one short status note, and take the next minute slowly.',
            'You are still connected to the mission team. Let us reset with one grounding cue and one simple task.',
            'I hear isolation in your status. We will keep this small: breathe, identify your stress level, then request a connection window.'
        ],
        'exhausted' => [
            'Fatigue detected. Reduce noncritical workload, hydrate, and protect the next sleep window.',
            'Your energy sounds low. Pause if safe, log fatigue, and avoid stacking complex tasks until you recover.',
            'Exhaustion can affect judgment. Slow down, confirm hydration, and ask mission control to review task priority.'
        ],
        'confused' => [
            'Confusion detected. Stop nonessential activity, reorient to the checklist, and report dizziness or visual changes immediately.',
            'Let us simplify. Confirm your location, current phase, and the next single instruction from mission control.',
            'Disorientation needs attention. Hold position if safe, breathe slowly, and ask for checklist confirmation.'
        ]
    ];

    return $emotionResponses[$emotion] ?? [$phase['chatbot_message']];
}

function build_rule_based_chatbot_response($phase, $userMessage)
{
    $detectedEmotion = detect_rule_based_emotion($userMessage, $phase);
    $confidenceScore = get_emotion_confidence_score($detectedEmotion);
    $responses = get_phase_guidance($phase, $detectedEmotion);
    $response = pick_response_variation($responses, $phase['phase_id'], $detectedEmotion, $userMessage);
    $environmentControl = get_environment_control($detectedEmotion, $phase['phase_id']);
    $responseTimestamp = gmdate('c');
    $messageForHistory = $userMessage === '' ? '[no user message provided]' : $userMessage;

    return [
        'status' => 'success',
        'source' => 'rule_based_placeholder',
        'detected_emotion' => $detectedEmotion,
        'confidence_score' => $confidenceScore,
        'response_chatbot' => $response,
        'environment_control_trigger' => $environmentControl,
        'response_timestamp' => $responseTimestamp,
        'conversation_history' => [
            [
                'role' => 'astronaut',
                'message' => $messageForHistory,
                'timestamp' => $responseTimestamp
            ],
            [
                'role' => 'astrohealth_bot',
                'message' => $response,
                'timestamp' => $responseTimestamp
            ]
        ],
        'mission_context' => [
            'phase_id' => $phase['phase_id'],
            'phase_title' => $phase['phase_title'],
            'alert_level' => $phase['alert_level']
        ]
    ];
}

send_json(build_rule_based_chatbot_response($phase, $userMessage));
