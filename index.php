<?php
/**
 * Lead CRM - Login Page
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/database.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

// Handle logout FIRST (before redirect check)
if (isset($_GET['logout'])) {
    logoutUser();
    redirect(APP_URL . '/index.php');
}

// Redirect if already logged in
if (isLoggedIn()) {
    redirect(APP_URL . '/pages/dashboard.php');
}

$error = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isLoginLocked()) {
        $mins = getLockoutMinutes();
        $error = "Too many failed attempts. Please try again in {$mins} minute(s).";
    } else {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Please enter username and password.';
        } elseif (loginUser($username, $password)) {
            redirect(APP_URL . '/pages/dashboard.php');
        } else {
            $attempts = $_SESSION['login_attempts'] ?? 0;
            $remaining = 5 - $attempts;
            if ($remaining > 0) {
                $error = "Invalid username or password. {$remaining} attempt(s) remaining.";
            } else {
                $mins = getLockoutMinutes();
                $error = "Too many failed attempts. Account locked for {$mins} minute(s).";
            }
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    logoutUser();
    redirect(APP_URL . '/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#6366f1">
    <title>Login - <?= APP_NAME ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 50%, #dbeafe 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
        }

        .logo-icon i {
            font-size: 36px;
            color: white;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #6366f1 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .logo-subtitle {
            color: #64748b;
            font-size: 15px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 8px 32px rgba(99, 102, 241, 0.12);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-radius: 12px;
            padding: 14px 18px;
            color: #1e293b;
            font-size: 15px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.9);
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            color: #1e293b;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            border: none;
            padding: 14px 30px;
            font-weight: 600;
            border-radius: 12px;
            font-size: 15px;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.35);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #9333ea);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.5);
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(99, 102, 241, 0.12);
            border-right: none;
            color: #64748b;
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .alert {
            border-radius: 12px;
            border: none;
            backdrop-filter: blur(20px);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.12);
            color: #b45309;
        }

        .secure-text {
            text-align: center;
            margin-top: 24px;
            color: #94a3b8;
            font-size: 13px;
        }

        .secure-text i {
            color: #10b981;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo-section">
            <div class="logo-icon">
                <i class="bi bi-heart-pulse"></i>
            </div>
            <div class="logo-text">Lead Gravity</div>
            <p class="logo-subtitle">Built for Marketers. Trusted by Clients.</p>
        </div>

        <div class="login-card">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i><?= e($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'unauthorized'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-shield-exclamation me-2"></i>Please login to continue.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="POST" class="mt-3">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter username" required
                            autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter password"
                            required>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </div>

                <div class="secure-text">
                    <i class="bi bi-shield-check me-1"></i>Secure Login
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>