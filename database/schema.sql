-- AstroHealth future MySQL schema.
-- This file is prepared for later database integration only.
-- The current application still reads from data-schema.json through the PHP API layer.

SET NAMES utf8mb4;
SET time_zone = '+00:00';

-- Stores astronauts monitored by AstroHealth.
-- Supports the current data-schema.json astronaut object:
-- id, name, and mission_status.
CREATE TABLE astronauts (
    astronaut_id VARCHAR(50) NOT NULL,
    full_name VARCHAR(120) NOT NULL,
    mission_status VARCHAR(40) NOT NULL DEFAULT 'ACTIVE',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (astronaut_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores each mission phase and its display/risk metadata.
-- Supports phase_order, phase_id, phase_title, alert_level, color_status,
-- highlighted_body_zone, highlighted_body_zones, and telemetry_chart.
CREATE TABLE mission_phases (
    phase_id VARCHAR(80) NOT NULL,
    phase_order INT NOT NULL,
    phase_title VARCHAR(120) NOT NULL,
    alert_level ENUM('normal', 'warning', 'serious', 'emergency') NOT NULL,
    color_status ENUM('green', 'yellow', 'orange', 'red') NOT NULL,
    highlighted_body_zone VARCHAR(40) NULL,
    highlighted_body_zones JSON NULL,
    telemetry_chart JSON NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (phase_id),
    UNIQUE KEY uq_mission_phases_order (phase_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores Adam's biometric readings for each mission phase.
-- Supports the current vital sign fields from data-schema.json:
-- heart_rate, blood_pressure, oxygen_level, radiation_level, sleep_hours,
-- bone_density, exercise_status, and mental_status.
CREATE TABLE biometrics (
    biometric_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    astronaut_id VARCHAR(50) NOT NULL,
    phase_id VARCHAR(80) NOT NULL,
    heart_rate VARCHAR(40) NOT NULL,
    blood_pressure VARCHAR(40) NOT NULL,
    oxygen_level VARCHAR(40) NOT NULL,
    radiation_level VARCHAR(40) NOT NULL,
    sleep_hours VARCHAR(40) NOT NULL,
    bone_density VARCHAR(40) NOT NULL,
    exercise_status VARCHAR(80) NOT NULL,
    mental_status VARCHAR(80) NOT NULL,
    recorded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (biometric_id),
    KEY idx_biometrics_astronaut_phase (astronaut_id, phase_id),
    CONSTRAINT fk_biometrics_astronaut
        FOREIGN KEY (astronaut_id) REFERENCES astronauts (astronaut_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_biometrics_phase
        FOREIGN KEY (phase_id) REFERENCES mission_phases (phase_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores AI risk predictions for each phase.
-- Currently this maps to rule_based_placeholder output from api/risk_predict.php.
-- Later it can store Taqwa AI model output without changing the frontend JSON contract.
CREATE TABLE ai_predictions (
    prediction_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    astronaut_id VARCHAR(50) NOT NULL,
    phase_id VARCHAR(80) NOT NULL,
    source VARCHAR(80) NOT NULL DEFAULT 'rule_based_placeholder',
    risk_level VARCHAR(40) NOT NULL,
    predicted_problem TEXT NOT NULL,
    reasoning TEXT NOT NULL,
    recommended_action TEXT NOT NULL,
    highlighted_body_zones JSON NULL,
    model_name VARCHAR(120) NULL,
    confidence_score DECIMAL(5,4) NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (prediction_id),
    KEY idx_ai_predictions_astronaut_phase (astronaut_id, phase_id),
    CONSTRAINT fk_ai_predictions_astronaut
        FOREIGN KEY (astronaut_id) REFERENCES astronauts (astronaut_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_ai_predictions_phase
        FOREIGN KEY (phase_id) REFERENCES mission_phases (phase_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores chatbot interactions and environment-control suggestions.
-- Supports the current api/chatbot.php fields:
-- detected_emotion, confidence_score, response_chatbot,
-- and environment_control_trigger.
CREATE TABLE chatbot_logs (
    chat_log_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    astronaut_id VARCHAR(50) NOT NULL,
    phase_id VARCHAR(80) NOT NULL,
    source VARCHAR(80) NOT NULL DEFAULT 'rule_based_placeholder',
    user_message TEXT NULL,
    detected_emotion VARCHAR(80) NOT NULL,
    confidence_score DECIMAL(5,4) NULL,
    response_chatbot TEXT NOT NULL,
    environment_control_trigger JSON NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (chat_log_id),
    KEY idx_chatbot_logs_astronaut_phase (astronaut_id, phase_id),
    CONSTRAINT fk_chatbot_logs_astronaut
        FOREIGN KEY (astronaut_id) REFERENCES astronauts (astronaut_id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_chatbot_logs_phase
        FOREIGN KEY (phase_id) REFERENCES mission_phases (phase_id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
