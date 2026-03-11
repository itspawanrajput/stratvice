<?php
/**
 * Lead Gravity - Installation Script
 * Run this once to set up the database
 */

$pageTitle = 'Install Lead Gravity';
$error = '';
$success = '';

// Check if already installed
$configFile = __DIR__ . '/config.php';
$configExists = file_exists($configFile);

// If config exists and database has users, block access
if ($configExists) {
    require_once $configFile;
    try {
        if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
            $testPdo = new PDO("sqlite:" . DB_SQLITE_PATH);
        } else {
            $testPdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASS);
        }
        $testPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $userCount = $testPdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        if ($userCount > 0) {
            http_response_code(403);
            die('<div style="font-family:Inter,sans-serif;text-align:center;padding:60px;color:#64748b;"><h2 style="color:#ef4444;">⛔ Already Installed</h2><p>Lead Gravity is already installed. <a href="index.php">Go to login</a></p><p style="font-size:12px;margin-top:20px;">If you need to reinstall, delete <code>config.php</code> first.</p></div>');
        }
    } catch (Exception $e) {
        // Table doesn't exist yet, proceed with install
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbHost = $_POST['db_host'] ?? 'localhost';
    $dbName = $_POST['db_name'] ?? '';
    $dbUser = $_POST['db_user'] ?? '';
    $dbPass = $_POST['db_pass'] ?? '';
    $appUrl = rtrim($_POST['app_url'] ?? '', '/');
    $adminUser = $_POST['admin_user'] ?? '';
    $adminPass = $_POST['admin_pass'] ?? '';
    $adminEmail = $_POST['admin_email'] ?? '';
    $adminName = $_POST['admin_name'] ?? '';

    // Validate inputs
    if (defined('DB_TYPE') && DB_TYPE === 'sqlite') {
        // SQLite setup
        try {
            $pdo = new PDO("sqlite:" . DB_SQLITE_PATH);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Convert MySQL schema to SQLite compatible schema
            // Remove ENGINE=InnoDB, AUTO_INCREMENT syntax differences, etc.

            // Clients table
            $pdo->exec("CREATE TABLE IF NOT EXISTS clients (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT,
                business_name TEXT,
                webhook_token TEXT UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Leads table
            $pdo->exec("CREATE TABLE IF NOT EXISTS leads (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                client_id INTEGER,
                external_id INTEGER,
                form_id INTEGER,
                form_name TEXT,
                name TEXT,
                email TEXT,
                phone TEXT,
                message TEXT,
                status TEXT DEFAULT 'new',
                quality_score INTEGER DEFAULT 0,
                notes TEXT,
                assigned_to INTEGER,
                is_spam INTEGER DEFAULT 0,
                ip_address TEXT,
                city TEXT,
                region TEXT,
                country TEXT,
                device_type TEXT,
                browser TEXT,
                os TEXT,
                landing_page TEXT,
                page_url TEXT,
                referrer_url TEXT,
                utm_source TEXT,
                utm_medium TEXT,
                utm_campaign TEXT,
                utm_content TEXT,
                utm_term TEXT,
                gclid TEXT,
                fbclid TEXT,
                lead_timestamp DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
            )");

            // Lead Activities table
            $pdo->exec("CREATE TABLE IF NOT EXISTS lead_activities (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                lead_id INTEGER,
                user_id INTEGER,
                action TEXT,
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
            )");

            // Users table
            $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                client_id INTEGER,
                username TEXT UNIQUE,
                password_hash TEXT,
                name TEXT,
                email TEXT,
                role TEXT DEFAULT 'agent',
                is_active INTEGER DEFAULT 1,
                last_login DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
            )");

            // Webhook Logs table
            $pdo->exec("CREATE TABLE IF NOT EXISTS webhook_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                client_id INTEGER,
                payload TEXT,
                status TEXT,
                message TEXT,
                ip_address TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");

            // Check if admin already exists
            $stmt = $pdo->prepare("SELECT count(*) FROM users WHERE username = ?");
            $stmt->execute([$adminUser]);
            if ($stmt->fetchColumn() == 0) {
                // Create default client
                $webhookToken = bin2hex(random_bytes(32));
                $stmt = $pdo->prepare("INSERT INTO clients (name, email, business_name, webhook_token) VALUES (?, ?, ?, ?)");
                $stmt->execute(['Default Client', $adminEmail, 'Default Business', $webhookToken]);
                $clientId = $pdo->lastInsertId();

                // Create admin user
                $passwordHash = password_hash($adminPass, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (client_id, username, password_hash, name, email, role) VALUES (?, ?, ?, ?, ?, 'admin')");
                $stmt->execute([$clientId, $adminUser, $passwordHash, $adminName, $adminEmail]);
            }

            // Write config file (keep existing settings but update app_url if changed)
            $configContent = "<?php
/**
 * Lead CRM - Configuration File
 * Auto-generated during installation
 */

// Database Configuration
define('DB_TYPE', 'sqlite'); // 'mysql' (production) or 'sqlite' (local testing)

// MySQL Settings (for production)
define('DB_HOST', 'localhost');
define('DB_NAME', 'lead_crm');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// SQLite Settings (for local testing)
define('DB_SQLITE_PATH', __DIR__ . '/database.sqlite');

// Application Settings
define('APP_NAME', 'Lead Gravity');
define('APP_URL', '{$appUrl}');
define('APP_VERSION', '1.0.0');

// Security
define('SESSION_NAME', 'lead_crm_session');
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 8);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
";
            file_put_contents($configFile, $configContent);

            $success = "Installation successful (SQLite)! Your webhook URL is: <br><code>{$appUrl}/api/webhook.php?token={$webhookToken}</code><br><br>You can now <a href='index.php'>login</a> with your admin credentials.";

        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }

    } elseif (empty($dbName) || empty($dbUser) || empty($adminUser) || empty($adminPass)) {
        $error = 'Please fill in all required fields.';
    } else {
        try {
            // Test database connection
            $dsn = "mysql:host={$dbHost};charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Create database if not exists
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `{$dbName}`");

            // Create tables
            $sql = "
            CREATE TABLE IF NOT EXISTS clients (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255),
                business_name VARCHAR(255),
                webhook_token VARCHAR(64) UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
            
            CREATE TABLE IF NOT EXISTS leads (
                id INT AUTO_INCREMENT PRIMARY KEY,
                client_id INT,
                external_id INT COMMENT 'submission_id from webhook',
                form_id INT,
                form_name VARCHAR(255),
                
                name VARCHAR(255),
                email VARCHAR(255),
                phone VARCHAR(50),
                message TEXT,
                
                status ENUM('new', 'contacted', 'qualified', 'won', 'lost') DEFAULT 'new',
                quality_score INT DEFAULT 0 COMMENT '1-10 rating',
                notes TEXT,
                assigned_to INT,
                is_spam BOOLEAN DEFAULT FALSE,
                
                ip_address VARCHAR(45),
                city VARCHAR(100),
                region VARCHAR(100),
                country VARCHAR(100),
                device_type VARCHAR(50),
                browser VARCHAR(100),
                os VARCHAR(100),
                
                landing_page TEXT,
                page_url TEXT,
                referrer_url TEXT,
                utm_source VARCHAR(255),
                utm_medium VARCHAR(255),
                utm_campaign VARCHAR(255),
                utm_content VARCHAR(255),
                utm_term VARCHAR(255),
                gclid VARCHAR(255),
                fbclid VARCHAR(255),
                
                lead_timestamp DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL,
                INDEX idx_client (client_id),
                INDEX idx_status (status),
                INDEX idx_campaign (utm_campaign),
                INDEX idx_date (lead_timestamp)
            ) ENGINE=InnoDB;
            
            CREATE TABLE IF NOT EXISTS lead_activities (
                id INT AUTO_INCREMENT PRIMARY KEY,
                lead_id INT,
                user_id INT,
                action VARCHAR(100),
                notes TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
            
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                client_id INT,
                username VARCHAR(100) UNIQUE,
                password_hash VARCHAR(255),
                name VARCHAR(255),
                email VARCHAR(255),
                role ENUM('admin', 'manager', 'agent') DEFAULT 'agent',
                is_active BOOLEAN DEFAULT TRUE,
                last_login DATETIME,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE SET NULL
            ) ENGINE=InnoDB;
            
            CREATE TABLE IF NOT EXISTS webhook_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                client_id INT,
                payload TEXT,
                status VARCHAR(50),
                message TEXT,
                ip_address VARCHAR(45),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_client (client_id),
                INDEX idx_status (status)
            ) ENGINE=InnoDB;
            ";

            // Execute SQL statements
            $pdo->exec($sql);

            // Create default client
            $webhookToken = bin2hex(random_bytes(32));
            $stmt = $pdo->prepare("INSERT INTO clients (name, email, business_name, webhook_token) VALUES (?, ?, ?, ?)");
            $stmt->execute(['Default Client', $adminEmail, 'Default Business', $webhookToken]);
            $clientId = $pdo->lastInsertId();

            // Create admin user
            $passwordHash = password_hash($adminPass, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (client_id, username, password_hash, name, email, role) VALUES (?, ?, ?, ?, ?, 'admin')");
            $stmt->execute([$clientId, $adminUser, $passwordHash, $adminName, $adminEmail]);

            // Write config file
            $configContent = "<?php
/**
 * Lead CRM - Configuration File
 * Auto-generated during installation
 */

// Database Configuration
define('DB_TYPE', 'mysql'); // 'mysql' (production) or 'sqlite' (local testing)

// MySQL Settings (for production)
define('DB_HOST', '{$dbHost}');
define('DB_NAME', '{$dbName}');
define('DB_USER', '{$dbUser}');
define('DB_PASS', '{$dbPass}');
define('DB_CHARSET', 'utf8mb4');

// SQLite Settings (for local testing)
define('DB_SQLITE_PATH', __DIR__ . '/database.sqlite');

// Application Settings
define('APP_NAME', 'Lead CRM');
define('APP_URL', '{$appUrl}');
define('APP_VERSION', '1.0.0');

// Security
define('SESSION_NAME', 'lead_crm_session');
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_MIN_LENGTH', 8);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Error Reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}
";
            file_put_contents($configFile, $configContent);

            $success = "Installation successful! Your webhook URL is: <br><code>{$appUrl}/api/webhook.php?token={$webhookToken}</code><br><br>You can now <a href='index.php'>login</a> with your admin credentials.";

        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        } catch (Exception $e) {
            $error = 'Installation error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .install-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        .logo {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .form-control,
        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            color: #fff;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
        }
    </style>
</head>

<body>
    <div class="install-card">
        <div class="text-center mb-4">
            <div class="logo">Lead Gravity</div>
            <p class="text-muted">Installation Wizard</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST">
                <h5 class="mb-3"><i class="bi bi-database me-2"></i>Database Settings</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Database Host</label>
                        <input type="text" name="db_host" class="form-control" value="localhost" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Database Name *</label>
                        <input type="text" name="db_name" class="form-control" value="lead_crm" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Database User *</label>
                        <input type="text" name="db_user" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Database Password</label>
                        <input type="password" name="db_pass" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Application URL *</label>
                    <input type="url" name="app_url" class="form-control" placeholder="https://yourdomain.com/crm" required>
                    <small class="text-muted">Full URL to your CRM installation (without trailing slash)</small>
                </div>

                <hr class="my-4">

                <h5 class="mb-3"><i class="bi bi-person-gear me-2"></i>Admin Account</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Admin Username *</label>
                        <input type="text" name="admin_user" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admin Password *</label>
                        <input type="password" name="admin_pass" class="form-control" required minlength="8">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Admin Name *</label>
                        <input type="text" name="admin_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Admin Email *</label>
                        <input type="email" name="admin_email" class="form-control" required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-download me-2"></i>Install Lead Gravity
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>