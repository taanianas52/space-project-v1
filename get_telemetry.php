<?php

$data = [
    "project" => "AstroHealth",
    "astronaut" => "Adam",
    "mission_phase" => "Earth Baseline",
    "warning_level" => "Normal",
    "heart_rate" => 72,
    "blood_pressure" => "118/76",
    "oxygen_level" => 98,
    "radiation_level" => 0.08,
    "sleep_hours" => 7.6,
    "bone_density" => 100,
    "exercise_status" => "Complete",
    "mental_status" => "Calm"
];

header("Content-Type: application/json");

echo json_encode($data);

?>
