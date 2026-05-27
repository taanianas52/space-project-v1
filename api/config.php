<?php
// Future MySQL configuration for AstroHealth.
// Current API endpoints still read from data-schema.json and do not require this file yet.

define('DB_HOST', 'localhost');
define('DB_NAME', 'astrohealth');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function get_database_connection()
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_TIMEOUT => 1
        ]);

        return $pdo;
    } catch (PDOException $error) {
        // Keep raw database details in server logs only.
        // Future API files should return a generic JSON message to the frontend.
        error_log('AstroHealth database connection failed: ' . $error->getMessage());
        return null;
    }
}

function send_database_unavailable_response()
{
    http_response_code(503);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database service is not available.'
    ]);
    exit;
}
