<?php
/**
 * Helper Functions
 */

/**
 * Sanitize input
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Escape output for HTML
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: {$url}");
    exit;
}

/**
 * Flash messages
 */
function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Generate random token
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Generate webhook token for client
 */
function generateWebhookToken() {
    return bin2hex(random_bytes(32));
}

/**
 * Format date
 */
function formatDate($date, $format = 'd M Y') {
    if (empty($date)) return '-';
    return date($format, strtotime($date));
}

/**
 * Format datetime
 */
function formatDateTime($datetime, $format = 'd M Y, h:i A') {
    if (empty($datetime)) return '-';
    return date($format, strtotime($datetime));
}

/**
 * Time ago format
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $diff = time() - $time;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff / 60) . ' mins ago';
    if ($diff < 86400) return floor($diff / 3600) . ' hours ago';
    if ($diff < 604800) return floor($diff / 86400) . ' days ago';
    
    return formatDate($datetime);
}

/**
 * Format phone number
 */
function formatPhone($phone) {
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    return $phone;
}

/**
 * Get status badge HTML
 */
function getStatusBadge($status) {
    $badges = [
        'new' => 'primary',
        'contacted' => 'info',
        'qualified' => 'warning',
        'won' => 'success',
        'lost' => 'danger'
    ];
    $class = $badges[$status] ?? 'secondary';
    return "<span class=\"badge bg-{$class}\">" . ucfirst($status) . "</span>";
}

/**
 * Get quality score badge
 */
function getQualityBadge($score) {
    if ($score >= 8) return '<span class="badge bg-success">' . $score . '/10</span>';
    if ($score >= 5) return '<span class="badge bg-warning">' . $score . '/10</span>';
    if ($score > 0) return '<span class="badge bg-danger">' . $score . '/10</span>';
    return '<span class="badge bg-secondary">N/A</span>';
}

/**
 * Get leads for current user/client
 */
function getLeads($filters = [], $limit = null, $offset = 0) {
    $db = db();
    $where = [];
    $params = [];
    
    // Filter by client for non-admin users
    if (!isAdmin() && getCurrentClientId()) {
        $where[] = "client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    // Apply filters
    if (!empty($filters['status'])) {
        $where[] = "status = :status";
        $params['status'] = $filters['status'];
    }
    
    if (!empty($filters['utm_source'])) {
        $where[] = "utm_source = :utm_source";
        $params['utm_source'] = $filters['utm_source'];
    }
    
    if (!empty($filters['utm_campaign'])) {
        $where[] = "utm_campaign = :utm_campaign";
        $params['utm_campaign'] = $filters['utm_campaign'];
    }
    
    if (!empty($filters['date_from'])) {
        $where[] = "DATE(lead_timestamp) >= :date_from";
        $params['date_from'] = $filters['date_from'];
    }
    
    if (!empty($filters['date_to'])) {
        $where[] = "DATE(lead_timestamp) <= :date_to";
        $params['date_to'] = $filters['date_to'];
    }
    
    if (!empty($filters['search'])) {
        $where[] = "(name LIKE :search OR email LIKE :search OR phone LIKE :search OR message LIKE :search)";
        $params['search'] = '%' . $filters['search'] . '%';
    }
    
    $whereClause = !empty($where) ? implode(' AND ', $where) : '1=1';
    
    $sql = "SELECT * FROM leads WHERE {$whereClause} ORDER BY created_at DESC";
    
    if ($limit) {
        $limit = (int) $limit;
        $offset = (int) $offset;
        $sql .= " LIMIT {$limit} OFFSET {$offset}";
    }
    
    return $db->fetchAll($sql, $params);
}

/**
 * Count leads with filters (for pagination)
 */
function getLeadsCount($filters = []) {
    $db = db();
    $where = [];
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $where[] = "client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    if (!empty($filters['status'])) {
        $where[] = "status = :status";
        $params['status'] = $filters['status'];
    }
    if (!empty($filters['utm_source'])) {
        $where[] = "utm_source = :utm_source";
        $params['utm_source'] = $filters['utm_source'];
    }
    if (!empty($filters['utm_campaign'])) {
        $where[] = "utm_campaign = :utm_campaign";
        $params['utm_campaign'] = $filters['utm_campaign'];
    }
    if (!empty($filters['date_from'])) {
        $where[] = "DATE(lead_timestamp) >= :date_from";
        $params['date_from'] = $filters['date_from'];
    }
    if (!empty($filters['date_to'])) {
        $where[] = "DATE(lead_timestamp) <= :date_to";
        $params['date_to'] = $filters['date_to'];
    }
    if (!empty($filters['search'])) {
        $where[] = "(name LIKE :search OR email LIKE :search OR phone LIKE :search OR message LIKE :search)";
        $params['search'] = '%' . $filters['search'] . '%';
    }
    
    $whereClause = !empty($where) ? implode(' AND ', $where) : '1=1';
    return $db->fetch("SELECT COUNT(*) as count FROM leads WHERE {$whereClause}", $params)['count'];
}

/**
 * Get lead by ID
 */
function getLead($id) {
    $db = db();
    $where = "id = :id";
    $params = ['id' => $id];
    
    // Check client access
    if (!isAdmin() && getCurrentClientId()) {
        $where .= " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    return $db->fetch("SELECT * FROM leads WHERE {$where}", $params);
}

/**
 * Get lead activities
 */
function getLeadActivities($leadId) {
    $db = db();
    return $db->fetchAll(
        "SELECT la.*, u.name as user_name 
         FROM lead_activities la 
         LEFT JOIN users u ON la.user_id = u.id 
         WHERE la.lead_id = :lead_id 
         ORDER BY la.created_at DESC",
        ['lead_id' => $leadId]
    );
}

/**
 * Add lead activity
 */
function addLeadActivity($leadId, $action, $notes = '') {
    $db = db();
    return $db->insert('lead_activities', [
        'lead_id' => $leadId,
        'user_id' => getCurrentUserId(),
        'action' => $action,
        'notes' => $notes
    ]);
}

/**
 * Get dashboard stats
 */
function getDashboardStats() {
    $db = db();
    $clientWhere = '';
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $clientWhere = " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    $today = date('Y-m-d');
    $weekStart = date('Y-m-d', strtotime('monday this week'));
    $monthStart = date('Y-m-01');
    
    return [
        'today' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE DATE(lead_timestamp) = :today {$clientWhere}", array_merge(['today' => $today], $params))['count'],
        'this_week' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE DATE(lead_timestamp) >= :week_start {$clientWhere}", array_merge(['week_start' => $weekStart], $params))['count'],
        'this_month' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE DATE(lead_timestamp) >= :month_start {$clientWhere}", array_merge(['month_start' => $monthStart], $params))['count'],
        'total' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE 1=1 {$clientWhere}", $params)['count'],
        'new' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE status = 'new' {$clientWhere}", $params)['count'],
        'contacted' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE status = 'contacted' {$clientWhere}", $params)['count'],
        'qualified' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE status = 'qualified' {$clientWhere}", $params)['count'],
        'won' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE status = 'won' {$clientWhere}", $params)['count'],
        'lost' => $db->fetch("SELECT COUNT(*) as count FROM leads WHERE status = 'lost' {$clientWhere}", $params)['count'],
    ];
}

/**
 * Get leads by source
 */
function getLeadsBySource($limit = 10) {
    $db = db();
    $clientWhere = '';
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $clientWhere = " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    $limit = (int) $limit;
    return $db->fetchAll(
        "SELECT COALESCE(utm_source, 'Direct') as source, COUNT(*) as count 
         FROM leads WHERE 1=1 {$clientWhere} 
         GROUP BY utm_source 
         ORDER BY count DESC 
         LIMIT {$limit}",
        $params
    );
}

/**
 * Get leads by campaign
 */
function getLeadsByCampaign($limit = 10) {
    $db = db();
    $clientWhere = '';
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $clientWhere = " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    $limit = (int) $limit;
    return $db->fetchAll(
        "SELECT COALESCE(utm_campaign, 'None') as campaign, COUNT(*) as count 
         FROM leads WHERE 1=1 {$clientWhere} 
         GROUP BY utm_campaign 
         ORDER BY count DESC 
         LIMIT {$limit}",
        $params
    );
}

/**
 * Get clients (admin only)
 */
function getClients() {
    $db = db();
    return $db->fetchAll("SELECT * FROM clients ORDER BY created_at DESC");
}

/**
 * Get client by ID
 */
function getClient($id) {
    $db = db();
    return $db->fetch("SELECT * FROM clients WHERE id = :id", ['id' => $id]);
}

/**
 * Get client by webhook token
 */
function getClientByToken($token) {
    $db = db();
    return $db->fetch("SELECT * FROM clients WHERE webhook_token = :token", ['token' => $token]);
}

/**
 * Log webhook request
 */
function logWebhook($clientId, $payload, $status, $message = '') {
    error_log("[Webhook] Client: {$clientId}, Status: {$status}, Message: {$message}");
    try {
        $db = db();
        $db->insert('webhook_logs', [
            'client_id' => $clientId,
            'payload' => is_string($payload) ? $payload : json_encode($payload),
            'status' => $status,
            'message' => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? ''
        ]);
    } catch (Exception $e) {
        error_log("Failed to log webhook: " . $e->getMessage());
    }
}

/**
 * Get recent notifications (new leads in last 24 hours)
 */
function getRecentNotifications($limit = 5) {
    $db = db();
    $clientWhere = '';
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $clientWhere = " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    $since = date('Y-m-d H:i:s', strtotime('-24 hours'));
    $params['since'] = $since;
    
    $limit = (int) $limit;
    return $db->fetchAll(
        "SELECT id, name, email, utm_source, created_at 
         FROM leads 
         WHERE created_at >= :since {$clientWhere}
         ORDER BY created_at DESC 
         LIMIT {$limit}",
        $params
    );
}

/**
 * Get new notification count
 */
function getNotificationCount() {
    $db = db();
    $clientWhere = '';
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $clientWhere = " AND client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    return $db->fetch(
        "SELECT COUNT(*) as count FROM leads WHERE status = 'new' {$clientWhere}",
        $params
    )['count'];
}

/**
 * Check for duplicate lead
 */
function isDuplicateLead($clientId, $externalId) {
    if (empty($externalId)) return false;
    $db = db();
    $existing = $db->fetch(
        "SELECT id FROM leads WHERE client_id = :client_id AND external_id = :external_id",
        ['client_id' => $clientId, 'external_id' => $externalId]
    );
    return $existing ? true : false;
}

/**
 * Get users for current client
 */
function getUsers() {
    $db = db();
    $where = "1=1";
    $params = [];
    
    if (!isAdmin() && getCurrentClientId()) {
        $where = "client_id = :client_id";
        $params['client_id'] = getCurrentClientId();
    }
    
    return $db->fetchAll("SELECT * FROM users WHERE {$where} ORDER BY name", $params);
}

/**
 * Export leads to CSV
 */
function exportLeadsToCsv($leads) {
    $filename = 'leads_export_' . date('Y-m-d_His') . '.csv';
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // Headers
    fputcsv($output, [
        'ID', 'Name', 'Email', 'Phone', 'Status', 'Quality Score',
        'City', 'Country', 'UTM Source', 'UTM Campaign', 'UTM Medium',
        'Landing Page', 'GCLID', 'Date', 'Notes'
    ]);
    
    // Data
    foreach ($leads as $lead) {
        fputcsv($output, [
            $lead['id'],
            $lead['name'],
            $lead['email'],
            $lead['phone'],
            $lead['status'],
            $lead['quality_score'],
            $lead['city'],
            $lead['country'],
            $lead['utm_source'],
            $lead['utm_campaign'],
            $lead['utm_medium'],
            $lead['landing_page'],
            $lead['gclid'],
            $lead['lead_timestamp'],
            $lead['notes']
        ]);
    }
    
    fclose($output);
    exit;
}
