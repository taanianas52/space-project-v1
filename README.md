# AstroHealth

AstroHealth is a space medical monitoring dashboard for astronaut Adam during a full mission lifecycle. It presents mission telemetry, health risk analysis, medical recommendations, chatbot support, body-zone highlighting, and a normalized health profile chart for the selected mission phase.

The project is currently an offline prototype. It uses JSON data and a PHP API layer to simulate future AI-powered medical monitoring without requiring MySQL or a real AI model yet.

## Project Idea

AstroHealth helps a mission medical team explain Adam's health state across key spaceflight phases:

- Earth baseline
- Pre-launch check
- Launch stress
- Zero gravity
- Exercise neglect
- Solar radiation storm
- Mental health isolation
- Landing preparation
- Rehabilitation

Each phase includes vital signs, alert status, AI-style reasoning, medical recommendations, chatbot messaging, body-zone highlighting, and chart data.

## Tech Stack

- HTML
- CSS
- JavaScript
- PHP
- JSON
- XAMPP Apache

Current project constraints:

- No React
- No Node.js app runtime
- No MySQL yet
- No real AI integration yet

## How To Run With XAMPP

1. Place the project folder at:

   ```text
   C:\xampp\htdocs\AstroHealth
   ```

2. Start Apache from the XAMPP Control Panel.

3. Open the dashboard:

   [http://localhost:8080/AstroHealth](http://localhost:8080/AstroHealth)

If your Apache port is different, adjust the URL to match your local XAMPP configuration.

## Project Structure

```text
AstroHealth/
  index.html              Main dashboard UI
  style.css               NASA-style dashboard styling
  script.js               Frontend logic and API integration
  data-schema.json        Shared mission data source
  get_telemetry.php       Legacy/simple telemetry file
  README.md               Project documentation
  api/
    telemetry_get.php     Returns the full JSON schema
    phase_get.php         Returns one mission phase by phase_id
    risk_predict.php      Rule-based placeholder risk analysis API
    chatbot.php           Rule-based placeholder chatbot API
```

## Current Status

Completed:

- Professional dark mission-control dashboard UI
- Mission phase buttons
- Vital signs cards
- AI Risk Analysis panel
- Medical Recommendations panel
- Chatbot panel
- Body schematic with risk highlighting
- Current Phase Health Profile chart
- JSON-driven mission data
- PHP API layer
- Local JSON fallback if PHP/API loading fails
- API connection status indicator
- Loading and error states

Not added yet:

- MySQL database
- Authentication
- Real AI model
- Python AI service
- Live sensor telemetry

## API Contract

All APIs return JSON and read from `data-schema.json` for the current offline prototype.

### `api/telemetry_get.php`

Returns the full project schema.

Example:

```http
GET /AstroHealth/api/telemetry_get.php
```

Response includes:

- `project`
- `schema_version`
- `astronaut`
- `phase_order`
- `mission_phases`

This endpoint is used by the frontend to load the mission phase index and local phase data.

### `api/phase_get.php?phase_id=...`

Returns one mission phase object.

Example:

```http
GET /AstroHealth/api/phase_get.php?phase_id=zero_gravity
```

Success response includes the full phase object, including:

- `phase_id`
- `phase_title`
- `alert_level`
- `heart_rate`
- `blood_pressure`
- `oxygen_level`
- `radiation_level`
- `sleep_hours`
- `bone_density`
- `exercise_status`
- `mental_status`
- `ai_prediction`
- `ai_reasoning`
- `medical_recommendation`
- `chatbot_message`
- `highlighted_body_zone`
- `highlighted_body_zones`
- `color_status`
- `telemetry_chart`

Error responses:

- `400` if `phase_id` is missing
- `404` if `phase_id` is invalid
- `500` if `data-schema.json` is missing or invalid

### `api/risk_predict.php`

Returns a clean AI-like risk analysis response using current rule-based placeholder logic.

Example:

```http
GET /AstroHealth/api/risk_predict.php?phase_id=solar_radiation_storm
```

Success response:

```json
{
  "status": "success",
  "source": "rule_based_placeholder",
  "phase_id": "solar_radiation_storm",
  "risk_level": "emergency",
  "predicted_problem": "Acute radiation exposure risk.",
  "reasoning": "Radiation level has exceeded emergency threshold and stress markers are elevated.",
  "recommended_action": "Move to the radiation shelter, limit exposure time, pause nonessential tasks, and monitor nausea, headache, and fatigue.",
  "highlighted_body_zones": ["head", "chest"]
}
```

Compatibility aliases are also included for current frontend/test code:

- `alert_level`
- `ai_engine`
- `ai_prediction`
- `ai_reasoning`
- `highlighted_body_zone`
- `medical_recommendation`

Error responses:

- `400` if `phase_id` is missing
- `404` if `phase_id` is invalid
- `500` if `data-schema.json` is missing or invalid

### `api/chatbot.php`

Returns a clean chatbot response using current rule-based placeholder logic.

Example:

```http
POST /AstroHealth/api/chatbot.php
Content-Type: application/json

{
  "phase_id": "mental_health_isolation",
  "user_message": "I feel lonely and tired"
}
```

Success response:

```json
{
  "status": "success",
  "source": "rule_based_placeholder",
  "detected_emotion": "mental_health_stress",
  "confidence_score": 0.92,
  "response_chatbot": "Adam, I hear you. You are not alone. Let us slow the next minute down: breathe in for four seconds, breathe out for six, and send one short status note to mission control.",
  "environment_control_trigger": {
    "change_lighting_color": "#FF8C00",
    "play_background_sound": "earth_rain.mp3"
  }
}
```

Error responses:

- `400` if the request body is not valid JSON
- `400` if `phase_id` is missing
- `400` if `phase_id` or `user_message` is not a string
- `404` if `phase_id` is invalid
- `405` if the request method is not `POST`
- `500` if `data-schema.json` is missing or invalid

## Frontend Data Flow

The dashboard uses `script.js` to load data in this order:

1. Try PHP API endpoints through XAMPP/Apache.
2. Use `api/telemetry_get.php` to load the mission phase list.
3. Use `api/phase_get.php?phase_id=...` when a phase is selected.
4. If PHP fails, fall back to local `data-schema.json`.
5. If local JSON fails, use the built-in frontend fallback object.

This keeps the dashboard working during presentations even if Apache or PHP has a temporary issue.

## Future Taqwa AI Integration

`api/risk_predict.php` and `api/chatbot.php` are prepared for future real AI integration.

Current behavior:

- Both files use `source: "rule_based_placeholder"`.
- Risk prediction is generated from existing phase data in `data-schema.json`.
- Chatbot emotion detection is simple keyword-based logic.
- Everything runs offline.

Future plan:

- Replace the placeholder functions in `risk_predict.php` and `chatbot.php` with calls to Taqwa's real AI model.
- The real AI model may run as a Python script, local service, or later backend service.
- Keep the same JSON response format so the frontend does not need to change.
- Keep `phase_id`, risk fields, chatbot fields, and body-zone fields stable.

Important frontend contract to preserve:

- `risk_predict.php` should continue returning `risk_level`, `predicted_problem`, `reasoning`, `recommended_action`, and `highlighted_body_zones`.
- `chatbot.php` should continue returning `detected_emotion`, `confidence_score`, `response_chatbot`, and `environment_control_trigger`.

## Cleanup Notes

The requested duplicate copy files for `index.html` and `style.css` were checked. They are not present in the current project folder, so no duplicate files were removed.

## Team Notes

- Keep `data-schema.json` as the shared source of truth until a database is added.
- Do not change API response formats casually; the frontend depends on stable JSON keys.
- Add MySQL only when the team is ready to store real users, missions, telemetry history, or AI logs.
- Add real AI only after the placeholder contracts are accepted by the team.
