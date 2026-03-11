<?php
/**
 * Authentication Functions
 */

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require authentication - redirect to login if not logged in
 */
function requireAuth() {
    if (!isLoggedIn()) {
        header('Location: ' . APP_URL . '/index.php?error=unauthorized');
        exit;
    }
}

/**
 * Require specific role
 */
function requireRole($roles) {
    requireAuth();
    if (!is_array($roles)) {
        $roles = [$roles];
    }
    if (!in_array($_SESSION['user_role'], $roles)) {
        header('Location: ' . APP_URL . '/pages/dashboard.php?error=forbidden');
        exit;
    }
}

/**
 * Login user
 */
function loginUser($username, $password) {
    // Check for rate limiting
    if (isLoginLocked()) {
        return false;
    }
    
    $db = db();
    $user = $db->fetch(
        "SELECT * FROM users WHERE username = :username AND is_active = 1",
        ['username' => $username]
    );
    
    if ($user && password_verify($password, $user['password_hash'])) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['client_id'] = $user['client_id'];
        
        // Clear failed login attempts
        unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
        
        // Update last login
        $db->update('users', 
            ['last_login' => date('Y-m-d H:i:s')],
            'id = :id',
            ['id' => $user['id']]
        );
        
        return true;
    }
    
    // Track failed attempts
    trackFailedLogin();
    return false;
}

/**
 * Logout user
 */
function logoutUser() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user's client ID
 */
function getCurrentClientId() {
    return $_SESSION['client_id'] ?? null;
}

/**
 * Check if current user is admin
 */
function isAdmin() {
    return ($_SESSION['user_role'] ?? '') === 'admin';
}

/**
 * Check if current user is manager or admin
 */
function isManager() {
    return in_array($_SESSION['user_role'] ?? '', ['admin', 'manager']);
}

/**
 * Generate CSRF token
 */
function generateCsrfToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Output CSRF hidden input field
 */
function csrfField() {
    return '<input type="hidden" name="csrf_token" value="' . generateCsrfToken() . '">';
}

/**
 * Verify CSRF token
 */
function verifyCsrfToken($token = null) {
    if ($token === null) {
        $token = $_POST['csrf_token'] ?? '';
    }
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Require valid CSRF token or die
 */
function requireCsrf() {
    if (!verifyCsrfToken()) {
        http_response_code(403);
        setFlash('error', 'Security token expired. Please try again.');
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? APP_URL);
        exit;
    }
}

/**
 * Track failed login attempts
 */
function trackFailedLogin() {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }
    $_SESSION['login_attempts']++;
    
    if ($_SESSION['login_attempts'] >= 5) {
        $_SESSION['login_locked_until'] = time() + 900; // 15 minutes
    }
}

/**
 * Check if login is locked due to too many attempts
 */
function isLoginLocked() {
    if (isset($_SESSION['login_locked_until'])) {
        if (time() < $_SESSION['login_locked_until']) {
            return true;
        }
        // Lock expired
        unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
    }
    return false;
}

/**
 * Get remaining lockout time in minutes
 */
function getLockoutMinutes() {
    if (isset($_SESSION['login_locked_until'])) {
        return max(0, ceil(($_SESSION['login_locked_until'] - time()) / 60));
    }
    return 0;
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Create user
 */
function createUser($data) {
    $db = db();
    return $db->insert('users', [
        'client_id' => $data['client_id'] ?? null,
        'username' => $data['username'],
        'password_hash' => hashPassword($data['password']),
        'name' => $data['name'],
        'email' => $data['email'],
        'role' => $data['role'] ?? 'agent'
    ]);
}
