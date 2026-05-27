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

-- Seed one example baseline biometric row for Adam.
-- This keeps the seed minimal while proving how current vital signs map into MySQL.
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
    'ADAM_01',
    'earth_baseline',
    '72 bpm',
    '118/76',
    '98%',
    '0.08 mSv',
    '7.6 h',
    '100%',
    'Complete',
    'Calm'
WHERE NOT EXISTS (
    SELECT 1
    FROM biometrics
    WHERE astronaut_id = 'ADAM_01'
      AND phase_id = 'earth_baseline'
      AND heart_rate = '72 bpm'
      AND blood_pressure = '118/76'
);

COMMIT;
