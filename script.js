const fallbackDashboardData = {
    project: "AstroHealth",
    schema_version: "1.0",
    astronaut: {
        id: "ADAM_01",
        name: "Adam",
        mission_status: "ACTIVE"
    },
    phase_order: [
        "earth_baseline",
        "pre_launch_check",
        "launch_stress",
        "zero_gravity",
        "exercise_neglect",
        "solar_radiation_storm",
        "mental_health_isolation",
        "landing_preparation",
        "rehabilitation"
    ],
    mission_phases: {
        earth_baseline: {
            phase_id: "earth_baseline",
            phase_title: "Earth Baseline",
            alert_level: "normal",
            heart_rate: "72 bpm",
            blood_pressure: "118/76",
            oxygen_level: "98%",
            radiation_level: "0.08 mSv",
            sleep_hours: "7.6 h",
            bone_density: "100%",
            exercise_status: "Complete",
            mental_status: "Calm",
            ai_prediction: "No active medical concern detected.",
            ai_reasoning: "Heart rate, oxygen level, blood pressure, sleep, bone density, and mental status are all within baseline mission limits.",
            medical_recommendation: "Continue baseline logging, hydration, normal sleep schedule, and pre-mission physical conditioning.",
            chatbot_message: "Adam, baseline readings are stable. Keep following the checklist and report any unusual symptoms.",
            highlighted_body_zone: "chest",
            highlighted_body_zones: ["chest"],
            color_status: "green",
            telemetry_chart: [26, 30, 28, 31, 29, 33, 30, 28, 32, 29, 31, 30]
        },
        pre_launch_check: {
            phase_id: "pre_launch_check",
            phase_title: "Pre-Launch Check",
            alert_level: "warning",
            heart_rate: "94 bpm",
            blood_pressure: "128/82",
            oxygen_level: "97%",
            radiation_level: "0.10 mSv",
            sleep_hours: "6.4 h",
            bone_density: "100%",
            exercise_status: "Complete",
            mental_status: "Focused",
            ai_prediction: "Mild pre-launch stress response.",
            ai_reasoning: "Heart rate and blood pressure are slightly elevated while oxygen and radiation values remain stable.",
            medical_recommendation: "Use controlled breathing, complete final hydration checks, and keep the medical team watching cardiovascular changes.",
            chatbot_message: "Pre-launch stress is expected. Try a 60-second breathing cycle and keep your headset open for support.",
            highlighted_body_zone: "chest",
            highlighted_body_zones: ["chest"],
            color_status: "yellow",
            telemetry_chart: [30, 34, 36, 40, 38, 42, 39, 41, 43, 40, 42, 44]
        },
        launch_stress: {
            phase_id: "launch_stress",
            phase_title: "Launch Stress",
            alert_level: "serious",
            heart_rate: "132 bpm",
            blood_pressure: "146/92",
            oxygen_level: "95%",
            radiation_level: "0.14 mSv",
            sleep_hours: "5.8 h",
            bone_density: "99.8%",
            exercise_status: "Paused",
            mental_status: "Alert",
            ai_prediction: "Acute cardiovascular load during launch.",
            ai_reasoning: "Heart rate and blood pressure have spiked under launch stress, while oxygen remains acceptable.",
            medical_recommendation: "Monitor heart rate and blood pressure every cycle. Keep Adam seated, secured, and coached through breathing commands.",
            chatbot_message: "Your heart rate is high because of launch stress. Stay strapped in and follow the crew medical breathing rhythm.",
            highlighted_body_zone: "chest",
            highlighted_body_zones: ["chest", "spine"],
            color_status: "orange",
            telemetry_chart: [38, 45, 58, 65, 72, 76, 70, 64, 58, 50, 46, 42]
        },
        zero_gravity: {
            phase_id: "zero_gravity",
            phase_title: "Zero Gravity",
            alert_level: "warning",
            heart_rate: "86 bpm",
            blood_pressure: "112/70",
            oxygen_level: "97%",
            radiation_level: "0.32 mSv",
            sleep_hours: "6.1 h",
            bone_density: "99.1%",
            exercise_status: "Partial",
            mental_status: "Curious",
            ai_prediction: "Microgravity adaptation with early skeletal unloading.",
            ai_reasoning: "Fluid shift indicators and early bone-density reduction appear while sleep rhythm begins to drift.",
            medical_recommendation: "Start resistance exercise, measure sleep rhythm, and watch lower-body strength and spinal comfort.",
            chatbot_message: "Zero gravity can feel strange at first. I will track sleep, balance, and lower-body changes closely.",
            highlighted_body_zone: "spine",
            highlighted_body_zones: ["spine", "legs"],
            color_status: "yellow",
            telemetry_chart: [35, 37, 40, 42, 43, 45, 44, 46, 48, 47, 49, 50]
        },
        exercise_neglect: {
            phase_id: "exercise_neglect",
            phase_title: "Exercise Neglect",
            alert_level: "serious",
            heart_rate: "78 bpm",
            blood_pressure: "116/74",
            oxygen_level: "97%",
            radiation_level: "0.36 mSv",
            sleep_hours: "6.8 h",
            bone_density: "96.4%",
            exercise_status: "Missed",
            mental_status: "Low drive",
            ai_prediction: "Bone-density loss risk in pelvis and legs.",
            ai_reasoning: "Exercise sessions were missed while bone density is trending down during microgravity exposure.",
            medical_recommendation: "Resume resistance training today, add lower-body loading, and schedule a medical check for bone-density trend review.",
            chatbot_message: "Adam, your exercise streak dropped. I can guide a short resistance session focused on legs and pelvis support.",
            highlighted_body_zone: "pelvis",
            highlighted_body_zones: ["pelvis", "legs"],
            color_status: "orange",
            telemetry_chart: [46, 45, 48, 50, 54, 58, 62, 66, 70, 73, 76, 78]
        },
        solar_radiation_storm: {
            phase_id: "solar_radiation_storm",
            phase_title: "Solar Radiation Storm",
            alert_level: "emergency",
            heart_rate: "118 bpm",
            blood_pressure: "136/86",
            oxygen_level: "96%",
            radiation_level: "2.80 mSv",
            sleep_hours: "4.9 h",
            bone_density: "96.2%",
            exercise_status: "Shelter",
            mental_status: "Concerned",
            ai_prediction: "Acute radiation exposure risk.",
            ai_reasoning: "Radiation level has exceeded emergency threshold and stress markers are elevated.",
            medical_recommendation: "Move to the radiation shelter, limit exposure time, pause nonessential tasks, and monitor nausea, headache, and fatigue.",
            chatbot_message: "Radiation alert. Go to the shielded area now and confirm when you are secured.",
            highlighted_body_zone: "chest",
            highlighted_body_zones: ["head", "chest"],
            color_status: "red",
            telemetry_chart: [45, 48, 52, 70, 82, 96, 92, 88, 76, 64, 56, 50]
        },
        mental_health_isolation: {
            phase_id: "mental_health_isolation",
            phase_title: "Mental Health Isolation",
            alert_level: "serious",
            heart_rate: "88 bpm",
            blood_pressure: "124/80",
            oxygen_level: "97%",
            radiation_level: "0.42 mSv",
            sleep_hours: "4.7 h",
            bone_density: "95.9%",
            exercise_status: "Partial",
            mental_status: "Isolated",
            ai_prediction: "Isolation stress with poor sleep and reduced motivation.",
            ai_reasoning: "Mental status is marked as isolated, sleep is low, and exercise completion is partial, suggesting rising psychological fatigue.",
            medical_recommendation: "Start a private support conversation, schedule a family message window, restore sleep routine, and reduce noncritical workload.",
            chatbot_message: "Adam, I am here with you. You are not alone in this mission. Tell me your stress level from 1 to 10, and we will reset the next hour together with one small step at a time.",
            highlighted_body_zone: "head",
            highlighted_body_zones: ["head"],
            color_status: "orange",
            telemetry_chart: [42, 44, 48, 50, 55, 59, 64, 69, 72, 74, 73, 70]
        },
        landing_preparation: {
            phase_id: "landing_preparation",
            phase_title: "Landing Preparation",
            alert_level: "warning",
            heart_rate: "102 bpm",
            blood_pressure: "130/84",
            oxygen_level: "97%",
            radiation_level: "0.30 mSv",
            sleep_hours: "6.0 h",
            bone_density: "95.7%",
            exercise_status: "Complete",
            mental_status: "Ready",
            ai_prediction: "Landing-related balance and lower-body weakness risk.",
            ai_reasoning: "Bone density remains reduced and re-entry preparation increases cardiovascular and spinal load.",
            medical_recommendation: "Continue lower-body conditioning, monitor hydration, prepare landing medical support, and plan assisted standing after return.",
            chatbot_message: "Landing prep is active. I will keep tracking balance, sleep, and leg strength for the return sequence.",
            highlighted_body_zone: "spine",
            highlighted_body_zones: ["spine", "legs"],
            color_status: "yellow",
            telemetry_chart: [55, 54, 56, 58, 57, 60, 62, 61, 59, 57, 55, 52]
        },
        rehabilitation: {
            phase_id: "rehabilitation",
            phase_title: "Rehabilitation",
            alert_level: "normal",
            heart_rate: "80 bpm",
            blood_pressure: "120/78",
            oxygen_level: "98%",
            radiation_level: "0.08 mSv",
            sleep_hours: "7.1 h",
            bone_density: "96.8%",
            exercise_status: "Rehab",
            mental_status: "Relieved",
            ai_prediction: "Post-mission recovery requires continued follow-up.",
            ai_reasoning: "Vital signs are normalizing and sleep is improving, while bone density still needs rehabilitation tracking.",
            medical_recommendation: "Continue rehabilitation, repeat bone-density assessment, track mood after mission, and increase exercise intensity slowly.",
            chatbot_message: "Welcome back, Adam. Your recovery trend is improving. Let us keep rehab steady and avoid overloading too soon.",
            highlighted_body_zone: "pelvis",
            highlighted_body_zones: ["pelvis", "legs"],
            color_status: "green",
            telemetry_chart: [62, 60, 58, 56, 54, 52, 50, 47, 44, 41, 38, 35]
        }
    }
};

const alertLabels = {
    normal: "Normal",
    warning: "Warning",
    serious: "Serious",
    emergency: "Emergency"
};

const alertClassByColor = {
    green: "normal",
    yellow: "temporary-warning",
    orange: "serious-warning",
    red: "emergency"
};

const dashboardShell = document.querySelector(".dashboard-shell");
const phaseButtons = document.getElementById("phaseButtons");
const vitalGrid = document.getElementById("vitalGrid");
const warningLevel = document.getElementById("warningLevel");
const statusDot = document.getElementById("statusDot");
const apiStatus = document.getElementById("apiStatus");
const apiStatusText = document.getElementById("apiStatusText");
const predictionTitle = document.getElementById("predictionTitle");
const aiRiskLevel = document.getElementById("aiRiskLevel");
const aiProblem = document.getElementById("aiProblem");
const aiReasoning = document.getElementById("aiReasoning");
const aiAction = document.getElementById("aiAction");
const recommendationText = document.getElementById("recommendationText");
const chatbotTitle = document.getElementById("chatbotTitle");
const chatbotText = document.getElementById("chatbotText");
const chatbotPanel = document.getElementById("chatbot");
const radiationAlert = document.getElementById("radiationAlert");
const telemetryChart = document.getElementById("telemetryChart");
const bodyZones = Array.from(document.querySelectorAll(".body-zone"));

let missionPhases = [];
let dashboardError = null;
let activePhaseRequest = 0;

async function loadLocalDashboardData() {
    try {
        const response = await fetch("data-schema.json", { cache: "no-store" });

        if (!response.ok) {
            throw new Error("data-schema.json could not be loaded");
        }

        return await response.json();
    } catch (error) {
        return fallbackDashboardData;
    }
}

async function loadDashboardIndex() {
    if (!shouldTryPhpApi()) {
        setApiStatus("fallback", "Demo Mode");
        return await loadLocalDashboardData();
    }

    try {
        const response = await fetch("api/telemetry_get.php", { cache: "no-store" });

        if (!response.ok) {
            throw new Error("PHP telemetry endpoint returned an error");
        }

        const data = await response.json();

        if (!data || !data.mission_phases) {
            throw new Error("PHP telemetry endpoint returned invalid data");
        }

        return data;
    } catch (error) {
        setApiStatus("fallback", "Demo Mode");
        showDashboardError("PHP API unavailable. Dashboard is using local mission data.");
        return await loadLocalDashboardData();
    }
}

function shouldTryPhpApi() {
    const isHttp = window.location.protocol === "http:" || window.location.protocol === "https:";
    const localHosts = ["localhost", "127.0.0.1", "::1"];

    return isHttp && localHosts.includes(window.location.hostname);
}

async function loadPhaseFromApi(phaseId) {
    if (!shouldTryPhpApi()) {
        throw new Error("PHP API is only available through localhost/XAMPP.");
    }

    const response = await fetch(`api/phase_get.php?phase_id=${encodeURIComponent(phaseId)}`, {
        cache: "no-store"
    });

    if (!response.ok) {
        throw new Error("PHP phase endpoint returned an error");
    }

    const phase = await response.json();

    if (!phase || phase.status === "error" || phase.phase_id !== phaseId) {
        throw new Error("PHP phase endpoint returned invalid data");
    }

    return phase;
}

function normalizeDashboardData(data) {
    const phaseOrder = data.phase_order || Object.keys(data.mission_phases || {});

    return phaseOrder
        .map((phaseId) => data.mission_phases[phaseId])
        .filter(Boolean);
}

function getAlertClass(phase) {
    return alertClassByColor[phase.color_status] || alertClassByColor.green;
}

function getAlertLabel(phase) {
    return alertLabels[phase.alert_level] || "Normal";
}

function getPhaseBodyZones(phase) {
    if (Array.isArray(phase.highlighted_body_zones) && phase.highlighted_body_zones.length > 0) {
        return phase.highlighted_body_zones;
    }

    return phase.highlighted_body_zone === "none" ? [] : [phase.highlighted_body_zone];
}

function getChatbotTitle(phase) {
    return phase.phase_id === "mental_health_isolation" ? "Support Channel Open" : "Mission Support";
}

function clampScore(value) {
    return Math.max(0, Math.min(100, Math.round(value)));
}

function getNumericValue(value) {
    const match = String(value || "").match(/[\d.]+/);
    return match ? Number(match[0]) : 0;
}

function getBloodPressureScore(value) {
    const [systolic, diastolic] = String(value || "").split("/").map(Number);

    if (!systolic || !diastolic) {
        return 0;
    }

    const systolicScore = 100 - Math.abs(systolic - 120) * 2;
    const diastolicScore = 100 - Math.abs(diastolic - 80) * 3;

    return clampScore((systolicScore + diastolicScore) / 2);
}

function getExerciseScore(status) {
    const normalizedStatus = String(status || "").toLowerCase();

    if (normalizedStatus.includes("complete") || normalizedStatus.includes("rehab")) {
        return 100;
    }

    if (normalizedStatus.includes("partial")) {
        return 60;
    }

    if (
        normalizedStatus.includes("missed") ||
        normalizedStatus.includes("paused") ||
        normalizedStatus.includes("shelter")
    ) {
        return 30;
    }

    return 70;
}

function getMentalScore(status) {
    const normalizedStatus = String(status || "").toLowerCase();

    if (normalizedStatus.includes("calm") || normalizedStatus.includes("relieved")) {
        return 100;
    }

    if (normalizedStatus.includes("focused") || normalizedStatus.includes("ready")) {
        return 90;
    }

    if (normalizedStatus.includes("curious") || normalizedStatus.includes("alert")) {
        return 75;
    }

    if (
        normalizedStatus.includes("isolated") ||
        normalizedStatus.includes("concerned") ||
        normalizedStatus.includes("low")
    ) {
        return 40;
    }

    return 70;
}

function getCurrentPhaseHealthMetrics(phase) {
    const heartRate = getNumericValue(phase.heart_rate);
    const oxygen = getNumericValue(phase.oxygen_level);
    const radiation = getNumericValue(phase.radiation_level);
    const sleep = getNumericValue(phase.sleep_hours);
    const boneDensity = getNumericValue(phase.bone_density);

    return [
        {
            label: "Heart Rate",
            score: clampScore(100 - Math.abs(heartRate - 72) * 1.4),
            rawValue: phase.heart_rate
        },
        {
            label: "Blood Pressure",
            score: getBloodPressureScore(phase.blood_pressure),
            rawValue: phase.blood_pressure
        },
        {
            label: "Oxygen Level",
            score: clampScore(oxygen),
            rawValue: phase.oxygen_level
        },
        {
            label: "Radiation Level",
            score: clampScore(100 - radiation * 30),
            rawValue: phase.radiation_level
        },
        {
            label: "Sleep Hours",
            score: clampScore((sleep / 8) * 100),
            rawValue: phase.sleep_hours
        },
        {
            label: "Bone Density",
            score: clampScore(boneDensity),
            rawValue: phase.bone_density
        },
        {
            label: "Exercise Status",
            score: getExerciseScore(phase.exercise_status),
            rawValue: phase.exercise_status
        },
        {
            label: "Mental Status",
            score: getMentalScore(phase.mental_status),
            rawValue: phase.mental_status
        }
    ];
}

function setApiStatus(state, text) {
    apiStatus.dataset.state = state;
    apiStatusText.textContent = text;
    const statusDetails = {
        "PHP + MySQL": "PHP API connected and phase data loaded from MySQL.",
        "JSON Fallback": "PHP API connected, but phase data loaded from JSON fallback.",
        "Demo Mode": "API unavailable. Dashboard is using local demo data.",
        Loading: "Checking the current data source.",
        Checking: "Checking the current data source.",
        "No Data": "No mission phase data could be loaded."
    };

    apiStatus.title = statusDetails[text] || text;
}

function setDashboardLoading(isLoading) {
    dashboardShell.classList.toggle("is-loading", isLoading);
    dashboardShell.setAttribute("aria-busy", String(isLoading));

    Array.from(phaseButtons.querySelectorAll("button")).forEach((button) => {
        button.disabled = isLoading;
    });
}

function shouldReduceMotion() {
    return window.matchMedia("(prefers-reduced-motion: reduce)").matches;
}

function waitForPhaseTransition() {
    if (shouldReduceMotion()) {
        return Promise.resolve();
    }

    return new Promise((resolve) => {
        window.setTimeout(resolve, 90);
    });
}

function finishPhaseTransition() {
    if (shouldReduceMotion()) {
        dashboardShell.classList.remove("phase-updating");
        return;
    }

    window.requestAnimationFrame(() => {
        dashboardShell.classList.remove("phase-updating");
    });
}

function showDashboardError(message) {
    if (!dashboardError) {
        dashboardError = document.createElement("p");
        dashboardError.className = "dashboard-error";
        phaseButtons.parentElement.insertBefore(dashboardError, phaseButtons);
    }

    dashboardError.textContent = message;
    dashboardError.hidden = false;
}

function clearDashboardError() {
    if (dashboardError) {
        dashboardError.hidden = true;
    }
}

function renderPhaseButtons() {
    phaseButtons.innerHTML = "";

    missionPhases.forEach((phase, index) => {
        const button = document.createElement("button");
        button.type = "button";
        button.textContent = phase.phase_title;
        button.addEventListener("click", () => setMissionPhase(index));
        phaseButtons.appendChild(button);
    });
}

function renderVitals(phase) {
    const alertClass = getAlertClass(phase);
    const alertLabel = getAlertLabel(phase);
    const vitals = [
        ["Heart Rate", phase.heart_rate, "Current cardiovascular load"],
        ["Blood Pressure", phase.blood_pressure, "Circulatory pressure"],
        ["Oxygen Level", phase.oxygen_level, "Blood oxygen saturation"],
        ["Radiation Level", phase.radiation_level, "Mission exposure reading"],
        ["Sleep Hours", phase.sleep_hours, "Last rest cycle"],
        ["Bone Density", phase.bone_density, "Skeletal health trend"],
        ["Exercise Status", phase.exercise_status, "Countermeasure completion"],
        ["Mental Status", phase.mental_status, "Behavioral health marker"]
    ];

    vitalGrid.innerHTML = "";

    vitals.forEach(([label, value, note]) => {
        const card = document.createElement("article");
        card.className = "vital-card";
        card.dataset.risk = alertClass;
        card.innerHTML = `
            <h3>${label}</h3>
            <strong>${value}</strong>
            <p>${note}</p>
            <span class="risk-badge ${alertClass}">${alertLabel}</span>
        `;
        vitalGrid.appendChild(card);
    });
}

function renderBodyState(phase) {
    const alertClass = getAlertClass(phase);
    const highlightedZones = getPhaseBodyZones(phase);
    const isMentalPhase = phase.phase_id === "mental_health_isolation";
    const isRadiationPhase = phase.phase_id === "solar_radiation_storm";

    bodyZones.forEach((zone) => {
        const partName = zone.dataset.part;
        const isActive = highlightedZones.includes(partName);
        const isMentalHead = isMentalPhase && partName === "head" && isActive;

        zone.classList.toggle("active", isActive);
        zone.classList.toggle("normal-part", isActive && alertClass === "normal");
        zone.classList.toggle("serious-part", isActive && alertClass === "serious-warning" && !isMentalHead);
        zone.classList.toggle("emergency-part", isActive && alertClass === "emergency");
        zone.classList.toggle("mental-part", isMentalHead);
    });

    radiationAlert.classList.toggle("active", isRadiationPhase);
    chatbotPanel.classList.toggle("active", isMentalPhase);
}

function renderChart(activePhase) {
    const metrics = getCurrentPhaseHealthMetrics(activePhase);
    const alertClass = getAlertClass(activePhase);
    const alertLabel = getAlertLabel(activePhase);

    telemetryChart.innerHTML = "";

    metrics.forEach((metric) => {
        const item = document.createElement("div");
        const bar = document.createElement("div");
        const value = document.createElement("span");
        const label = document.createElement("span");

        item.className = "chart-item";

        bar.className = "chart-bar";
        bar.dataset.risk = alertClass;
        bar.style.height = `${metric.score}%`;
        bar.title = `${activePhase.phase_title}: ${metric.label} ${metric.rawValue}, Score ${metric.score}, ${alertLabel}`;

        value.className = "chart-value";
        value.textContent = metric.score;

        label.className = "chart-label";
        label.textContent = metric.label;

        item.appendChild(value);
        item.appendChild(bar);
        item.appendChild(label);
        telemetryChart.appendChild(item);
    });
}

async function setMissionPhase(index) {
    const requestId = ++activePhaseRequest;
    const localPhase = missionPhases[index];
    const buttons = Array.from(phaseButtons.querySelectorAll("button"));

    buttons.forEach((button, buttonIndex) => {
        button.classList.toggle("active", buttonIndex === index);
    });

    setDashboardLoading(true);
    setApiStatus("checking", "Loading");
    clearDashboardError();
    dashboardShell.classList.add("phase-updating");

    let phase = localPhase;

    try {
        phase = await loadPhaseFromApi(localPhase.phase_id);
        if (phase.data_source === "mysql") {
            setApiStatus("online", "PHP + MySQL");
        } else if (phase.data_source === "json_fallback") {
            setApiStatus("fallback", "JSON Fallback");
        } else {
            setApiStatus("online", "PHP API");
        }
    } catch (error) {
        phase = localPhase;
        setApiStatus("fallback", "Demo Mode");
        showDashboardError("Could not reach api/phase_get.php. Showing local fallback data for this phase.");
    }

    if (requestId !== activePhaseRequest) {
        setDashboardLoading(false);
        dashboardShell.classList.remove("phase-updating");
        return;
    }

    await waitForPhaseTransition();

    const alertClass = getAlertClass(phase);
    const alertLabel = getAlertLabel(phase);

    warningLevel.textContent = alertLabel;
    statusDot.className = `status-dot ${alertClass}`;
    predictionTitle.textContent = phase.ai_prediction;
    aiRiskLevel.textContent = alertLabel;
    aiRiskLevel.className = `risk-badge ${alertClass}`;
    aiProblem.textContent = phase.ai_prediction;
    aiReasoning.textContent = phase.ai_reasoning;
    aiAction.textContent = phase.medical_recommendation;
    recommendationText.textContent = phase.medical_recommendation;
    chatbotTitle.textContent = getChatbotTitle(phase);
    chatbotText.textContent = phase.chatbot_message;

    renderVitals(phase);
    renderBodyState(phase);
    renderChart(phase);
    finishPhaseTransition();
    setDashboardLoading(false);
}

async function initializeDashboard() {
    setApiStatus("checking", "Checking");
    setDashboardLoading(true);

    const data = await loadDashboardIndex();
    missionPhases = normalizeDashboardData(data);

    if (missionPhases.length === 0) {
        setApiStatus("error", "No Data");
        showDashboardError("No mission phases were found in the API or local fallback data.");
        setDashboardLoading(false);
        return;
    }

    renderPhaseButtons();
    await setMissionPhase(0);
}

initializeDashboard();
