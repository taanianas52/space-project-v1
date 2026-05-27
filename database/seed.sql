-- AstroHealth future MySQL seed data.
-- Import this after database/schema.sql.
-- The current app still runs from data-schema.json, so this seed is preparation only.

SET NAMES utf8mb4;
SET time_zone = '+00:00';

USE astrohealth;

START TRANSACTION;

-- Seed the current astronaut from data-schema.json.
INSERT INTO astronauts (astronaut_id, full_name, mission_status)
VALUES ('ADAM_01', 'Adam', 'ACTIVE')
ON DUPLICATE KEY UPDATE
    full_name = VALUES(full_name),
    mission_status = VALUES(mission_status);

-- Seed the 9 mission phases from the current mission lifecycle.
INSERT INTO mission_phases (
    phase_id,
    phase_order,
    phase_title,
    alert_level,
    color_status,
    highlighted_body_zone,
    highlighted_body_zones,
    telemetry_chart
) VALUES
(
    'earth_baseline',
    1,
    'Earth Baseline',
    'normal',
    'green',
    'chest',
    JSON_ARRAY('chest'),
    JSON_ARRAY(26, 30, 28, 31, 29, 33, 30, 28, 32, 29, 31, 30)
),
(
    'pre_launch_check',
    2,
    'Pre-Launch Check',
    'warning',
    'yellow',
    'chest',
    JSON_ARRAY('chest'),
    JSON_ARRAY(30, 34, 36, 40, 38, 42, 39, 41, 43, 40, 42, 44)
),
(
    'launch_stress',
    3,
    'Launch Stress',
    'serious',
    'orange',
    'chest',
    JSON_ARRAY('chest', 'spine'),
    JSON_ARRAY(38, 45, 58, 65, 72, 76, 70, 64, 58, 50, 46, 42)
),
(
    'zero_gravity',
    4,
    'Zero Gravity',
    'warning',
    'yellow',
    'spine',
    JSON_ARRAY('spine', 'legs'),
    JSON_ARRAY(35, 37, 40, 42, 43, 45, 44, 46, 48, 47, 49, 50)
),
(
    'exercise_neglect',
    5,
    'Exercise Neglect',
    'serious',
    'orange',
    'pelvis',
    JSON_ARRAY('pelvis', 'legs'),
    JSON_ARRAY(46, 45, 48, 50, 54, 58, 62, 66, 70, 73, 76, 78)
),
(
    'solar_radiation_storm',
    6,
    'Solar Radiation Storm',
    'emergency',
    'red',
    'chest',
    JSON_ARRAY('head', 'chest'),
    JSON_ARRAY(45, 48, 52, 70, 82, 96, 92, 88, 76, 64, 56, 50)
),
(
    'mental_health_isolation',
    7,
    'Mental Health Isolation',
    'serious',
    'orange',
    'head',
    JSON_ARRAY('head'),
    JSON_ARRAY(42, 44, 48, 50, 55, 59, 64, 69, 72, 74, 73, 70)
),
(
    'landing_preparation',
    8,
    'Landing Preparation',
    'warning',
    'yellow',
    'spine',
    JSON_ARRAY('spine', 'legs'),
    JSON_ARRAY(55, 54, 56, 58, 57, 60, 62, 61, 59, 57, 55, 52)
),
(
    'rehabilitation',
    9,
    'Rehabilitation',
    'normal',
    'green',
    'pelvis',
    JSON_ARRAY('pelvis', 'legs'),
    JSON_ARRAY(62, 60, 58, 56, 54, 52, 50, 47, 44, 41, 38, 35)
)
ON DUPLICATE KEY UPDATE
    phase_order = VALUES(phase_order),
    phase_title = VALUES(phase_title),
    alert_level = VALUES(alert_level),
    color_status = VALUES(color_status),
    highlighted_body_zone = VALUES(highlighted_body_zone),
    highlighted_body_zones = VALUES(highlighted_body_zones),
    telemetry_chart = VALUES(telemetry_chart);

-- Seed example biometrics for every current mission phase.
INSERT INTO biometrics (
    astronaut_id,
    phase_id,
    heart_rate,
    blood_pressure,
    oxygen_level,
    radiation_level,
    sleep_hours,
    bone_density,
    exercise_status,
    mental_status
)
SELECT
    seed.astronaut_id,
    seed.phase_id,
    seed.heart_rate,
    seed.blood_pressure,
    seed.oxygen_level,
    seed.radiation_level,
    seed.sleep_hours,
    seed.bone_density,
    seed.exercise_status,
    seed.mental_status
FROM (
    SELECT 'ADAM_01' astronaut_id, 'earth_baseline' phase_id, '72 bpm' heart_rate, '118/76' blood_pressure, '98%' oxygen_level, '0.08 mSv' radiation_level, '7.6 h' sleep_hours, '100%' bone_density, 'Complete' exercise_status, 'Calm' mental_status
    UNION ALL SELECT 'ADAM_01', 'pre_launch_check', '94 bpm', '128/82', '97%', '0.10 mSv', '6.4 h', '100%', 'Complete', 'Focused'
    UNION ALL SELECT 'ADAM_01', 'launch_stress', '132 bpm', '146/92', '95%', '0.14 mSv', '5.8 h', '99.8%', 'Paused', 'Alert'
    UNION ALL SELECT 'ADAM_01', 'zero_gravity', '86 bpm', '112/70', '97%', '0.32 mSv', '6.1 h', '99.1%', 'Partial', 'Curious'
    UNION ALL SELECT 'ADAM_01', 'exercise_neglect', '78 bpm', '116/74', '97%', '0.36 mSv', '6.8 h', '96.4%', 'Missed', 'Low drive'
    UNION ALL SELECT 'ADAM_01', 'solar_radiation_storm', '118 bpm', '136/86', '96%', '2.80 mSv', '4.9 h', '96.2%', 'Shelter', 'Concerned'
    UNION ALL SELECT 'ADAM_01', 'mental_health_isolation', '88 bpm', '124/80', '97%', '0.42 mSv', '4.7 h', '95.9%', 'Partial', 'Isolated'
    UNION ALL SELECT 'ADAM_01', 'landing_preparation', '102 bpm', '130/84', '97%', '0.30 mSv', '6.0 h', '95.7%', 'Complete', 'Ready'
    UNION ALL SELECT 'ADAM_01', 'rehabilitation', '80 bpm', '120/78', '98%', '0.08 mSv', '7.1 h', '96.8%', 'Rehab', 'Relieved'
) AS seed
WHERE NOT EXISTS (
    SELECT 1
    FROM biometrics
    WHERE biometrics.astronaut_id = seed.astronaut_id
      AND biometrics.phase_id = seed.phase_id
);

-- Seed rule-based placeholder AI predictions for every current mission phase.
INSERT INTO ai_predictions (
    astronaut_id,
    phase_id,
    source,
    risk_level,
    predicted_problem,
    reasoning,
    recommended_action,
    highlighted_body_zones,
    model_name,
    confidence_score
)
SELECT
    seed.astronaut_id,
    seed.phase_id,
    'rule_based_placeholder',
    seed.risk_level,
    seed.predicted_problem,
    seed.reasoning,
    seed.recommended_action,
    seed.highlighted_body_zones,
    'rule_based_placeholder',
    seed.confidence_score
FROM (
    SELECT 'ADAM_01' astronaut_id, 'earth_baseline' phase_id, 'normal' risk_level, 'No active medical concern detected.' predicted_problem, 'Heart rate, oxygen level, blood pressure, sleep, bone density, and mental status are all within baseline mission limits.' reasoning, 'Continue baseline logging, hydration, normal sleep schedule, and pre-mission physical conditioning.' recommended_action, JSON_ARRAY('chest') highlighted_body_zones, 0.9000 confidence_score
    UNION ALL SELECT 'ADAM_01', 'pre_launch_check', 'warning', 'Mild pre-launch stress response.', 'Heart rate and blood pressure are slightly elevated while oxygen and radiation values remain stable.', 'Use controlled breathing, complete final hydration checks, and keep the medical team watching cardiovascular changes.', JSON_ARRAY('chest'), 0.8800
    UNION ALL SELECT 'ADAM_01', 'launch_stress', 'serious', 'Acute cardiovascular load during launch.', 'Heart rate and blood pressure have spiked under launch stress, while oxygen remains acceptable.', 'Monitor heart rate and blood pressure every cycle. Keep Adam seated, secured, and coached through breathing commands.', JSON_ARRAY('chest', 'spine'), 0.9100
    UNION ALL SELECT 'ADAM_01', 'zero_gravity', 'warning', 'Microgravity adaptation with early skeletal unloading.', 'Fluid shift indicators and early bone-density reduction appear while sleep rhythm begins to drift.', 'Start resistance exercise, measure sleep rhythm, and watch lower-body strength and spinal comfort.', JSON_ARRAY('spine', 'legs'), 0.8700
    UNION ALL SELECT 'ADAM_01', 'exercise_neglect', 'serious', 'Bone-density loss risk in pelvis and legs.', 'Exercise sessions were missed while bone density is trending down during microgravity exposure.', 'Resume resistance training today, add lower-body loading, and schedule a medical check for bone-density trend review.', JSON_ARRAY('pelvis', 'legs'), 0.9200
    UNION ALL SELECT 'ADAM_01', 'solar_radiation_storm', 'emergency', 'Acute radiation exposure risk.', 'Radiation level has exceeded emergency threshold and stress markers are elevated.', 'Move to the radiation shelter, limit exposure time, pause nonessential tasks, and monitor nausea, headache, and fatigue.', JSON_ARRAY('head', 'chest'), 0.9600
    UNION ALL SELECT 'ADAM_01', 'mental_health_isolation', 'serious', 'Isolation stress with poor sleep and reduced motivation.', 'Mental status is marked as isolated, sleep is low, and exercise completion is partial, suggesting rising psychological fatigue.', 'Start a private support conversation, schedule a family message window, restore sleep routine, and reduce noncritical workload.', JSON_ARRAY('head'), 0.9300
    UNION ALL SELECT 'ADAM_01', 'landing_preparation', 'warning', 'Landing-related balance and lower-body weakness risk.', 'Bone density remains reduced and re-entry preparation increases cardiovascular and spinal load.', 'Continue lower-body conditioning, monitor hydration, prepare landing medical support, and plan assisted standing after return.', JSON_ARRAY('spine', 'legs'), 0.8600
    UNION ALL SELECT 'ADAM_01', 'rehabilitation', 'normal', 'Post-mission recovery requires continued follow-up.', 'Vital signs are normalizing and sleep is improving, while bone density still needs rehabilitation tracking.', 'Continue rehabilitation, repeat bone-density assessment, track mood after mission, and increase exercise intensity slowly.', JSON_ARRAY('pelvis', 'legs'), 0.8900
) AS seed
WHERE NOT EXISTS (
    SELECT 1
    FROM ai_predictions
    WHERE ai_predictions.astronaut_id = seed.astronaut_id
      AND ai_predictions.phase_id = seed.phase_id
);

-- Seed default chatbot messages for every current mission phase.
INSERT INTO chatbot_logs (
    astronaut_id,
    phase_id,
    source,
    user_message,
    detected_emotion,
    confidence_score,
    response_chatbot,
    environment_control_trigger
)
SELECT
    seed.astronaut_id,
    seed.phase_id,
    'rule_based_placeholder',
    NULL,
    seed.detected_emotion,
    seed.confidence_score,
    seed.response_chatbot,
    JSON_OBJECT('change_lighting_color', '#2F80ED', 'play_background_sound', 'mission_ambient.mp3')
FROM (
    SELECT 'ADAM_01' astronaut_id, 'earth_baseline' phase_id, 'mission_status_check' detected_emotion, 0.7400 confidence_score, 'Adam, baseline readings are stable. Keep following the checklist and report any unusual symptoms.' response_chatbot
    UNION ALL SELECT 'ADAM_01', 'pre_launch_check', 'mission_status_check', 0.7400, 'Pre-launch stress is expected. Try a 60-second breathing cycle and keep your headset open for support.'
    UNION ALL SELECT 'ADAM_01', 'launch_stress', 'mission_status_check', 0.7400, 'Your heart rate is high because of launch stress. Stay strapped in and follow the crew medical breathing rhythm.'
    UNION ALL SELECT 'ADAM_01', 'zero_gravity', 'mission_status_check', 0.7400, 'Zero gravity can feel strange at first. I will track sleep, balance, and lower-body changes closely.'
    UNION ALL SELECT 'ADAM_01', 'exercise_neglect', 'mission_status_check', 0.7400, 'Adam, your exercise streak dropped. I can guide a short resistance session focused on legs and pelvis support.'
    UNION ALL SELECT 'ADAM_01', 'solar_radiation_storm', 'mission_status_check', 0.7400, 'Radiation alert. Go to the shielded area now and confirm when you are secured.'
    UNION ALL SELECT 'ADAM_01', 'mental_health_isolation', 'mental_health_stress', 0.9200, 'Adam, I am here with you. You are not alone in this mission. Tell me your stress level from 1 to 10, and we will reset the next hour together with one small step at a time.'
    UNION ALL SELECT 'ADAM_01', 'landing_preparation', 'mission_status_check', 0.7400, 'Landing prep is active. I will keep tracking balance, sleep, and leg strength for the return sequence.'
    UNION ALL SELECT 'ADAM_01', 'rehabilitation', 'mission_status_check', 0.7400, 'Welcome back, Adam. Your recovery trend is improving. Let us keep rehab steady and avoid overloading too soon.'
) AS seed
WHERE NOT EXISTS (
    SELECT 1
    FROM chatbot_logs
    WHERE chatbot_logs.astronaut_id = seed.astronaut_id
      AND chatbot_logs.phase_id = seed.phase_id
);

COMMIT;
