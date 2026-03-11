<?php
/**
 * Lead CRM - Configuration File
 * Copy this file to config.php and update with your settings.
 */

// Database Configuration
define('DB_TYPE', 'mysql'); // 'mysql' (production) or 'sqlite' (local testing)

// MySQL Settings (for production)
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');
define('DB_CHARSET', 'utf8mb4');

// SQLite Settings (for local testing)
define('DB_SQLITE_PATH', __DIR__ . '/database.sqlite');

// Application Settings
define('APP_NAME', 'Lead Gravity');
define('APP_URL', 'https://your-domain.com');
define('APP_VERSION', '1.1.0');

// Security
define('SESSION_NAME', 'lead_crm_session');
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 8);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start session with security settings
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}
