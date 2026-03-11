<?php
/**
 * Webhook Endpoint for Lead Gravity Plugin
 * 
 * URL: /api/webhook.php?token=CLIENT_TOKEN
 * Method: POST
 * Content-Type: application/json
 */

// Set headers for API response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Load configuration and dependencies
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Get webhook token from query string
$token = $_GET['token'] ?? '';

if (empty($token)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Missing webhook token']);
    logWebhook(0, '', 'error', 'Missing token');
    exit;
}

// Validate token and get client
$client = getClientByToken($token);

if (!$client) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Invalid webhook token']);
    logWebhook(0, '', 'error', 'Invalid token: ' . substr($token, 0, 10) . '...');
    exit;
}

// Get and parse JSON payload
$rawPayload = file_get_contents('php://input');
$payload = json_decode($rawPayload, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON payload']);
    logWebhook($client['id'], $rawPayload, 'error', 'Invalid JSON');
    exit;
}

// Validate required fields
if (empty($payload['event']) || $payload['event'] !== 'form_submission') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid event type']);
    logWebhook($client['id'], $rawPayload, 'error', 'Invalid event type');
    exit;
}

try {
    $db = db();
    
    // Extract data from payload
    $formData = $payload['form_data'] ?? [];
    $visitor = $payload['visitor'] ?? [];
    $attribution = $payload['attribution'] ?? [];
    
    // Prepare lead data
    $leadData = [
        'client_id' => $client['id'],
        'external_id' => $payload['submission_id'] ?? null,
        'form_id' => $payload['form_id'] ?? null,
        'form_name' => $payload['form_name'] ?? '',
        
        // Contact Info
        'name' => $formData['name'] ?? '',
        'email' => $formData['email'] ?? '',
        'phone' => $formData['phone'] ?? '',
        'message' => $formData['message'] ?? '',
        
        // Status
        'status' => 'new',
        'quality_score' => 0,
        
        // Visitor Info
        'ip_address' => $visitor['ip_address'] ?? '',
        'city' => $visitor['city'] ?? '',
        'region' => $visitor['region'] ?? '',
        'country' => $visitor['country'] ?? '',
        'device_type' => $visitor['device_type'] ?? '',
        'browser' => isset($visitor['browser']) ? $visitor['browser'] . ' ' . ($visitor['browser_version'] ?? '') : '',
        'os' => isset($visitor['os']) ? $visitor['os'] . ' ' . ($visitor['os_version'] ?? '') : '',
        
        // Attribution
        'landing_page' => $attribution['landing_page'] ?? '',
        'page_url' => $attribution['page_url'] ?? '',
        'referrer_url' => $attribution['referrer_url'] ?? '',
        'utm_source' => $attribution['utm_source'] ?? '',
        'utm_medium' => $attribution['utm_medium'] ?? '',
        'utm_campaign' => $attribution['utm_campaign'] ?? '',
        'utm_content' => $attribution['utm_content'] ?? '',
        'utm_term' => $attribution['utm_term'] ?? '',
        'gclid' => $attribution['gclid'] ?? '',
        'fbclid' => $attribution['fbclid'] ?? '',
        
        // Timestamp
        'lead_timestamp' => $payload['timestamp'] ?? date('Y-m-d H:i:s')
    ];
    
    // Check for duplicate leads
    $externalId = $leadData['external_id'];
    if (!empty($externalId) && isDuplicateLead($client['id'], $externalId)) {
        logWebhook($client['id'], $rawPayload, 'duplicate', 'Lead already exists: submission_id=' . $externalId);
        http_response_code(200);
        echo json_encode([
            'status' => 'duplicate',
            'message' => 'Lead already exists',
            'submission_id' => $externalId
        ]);
        exit;
    }
    
    // Insert lead
    $leadId = $db->insert('leads', $leadData);
    
    // Log success
    logWebhook($client['id'], $rawPayload, 'success', 'Lead created: ' . $leadId);
    
    // Add initial activity
    $db->insert('lead_activities', [
        'lead_id' => $leadId,
        'user_id' => null,
        'action' => 'lead_created',
        'notes' => 'Lead received via webhook from ' . ($payload['form_name'] ?? 'Unknown Form')
    ]);
    
    // Return success response
    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Lead created successfully',
        'lead_id' => $leadId
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Server error']);
    logWebhook($client['id'], $rawPayload, 'error', $e->getMessage());
    error_log("Webhook error: " . $e->getMessage());
}
